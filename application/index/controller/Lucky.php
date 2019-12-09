<?php
namespace app\index\controller;

use think\Db;

/**
 * 转盘控制器
 * @author tangtanglove
 */
class Lucky extends Common
{
    public function index(){
        exit;
       $lucky_results = Db::name('lucky_results')->where('member_id',UID)->where('is_win','not in','0,4,5,6,7,8')->order('add_time desc')->select();
       $this->assign('list',$lucky_results);            
       $web_lucky_score=config('web_lucky_score');
       $this->assign('web_lucky_score',$web_lucky_score);
       return $this->themeFetch('lucky');
    }
 
    //抽奖控制器
    public function choujiang(){
        $m_id = UID;//会员ID

        //获取当天的年份
        $y = date("Y");//获取当天的月份
        $m = date("m");//获取当天的号数
        $d = date("d");//将今天开始的年月日时分秒，转换成unix时间戳(开始示例：2015-10-12 00:00:00)
        $todayTime= mktime(0,0,0,$m,$d,$y);
        $web_lucky_cs=config('web_lucky_cs');
        

        //检查当天用户的抽奖次数
        $userlog = Db::name('lucky_results')->where('member_id',$m_id)->where('add_time','gt',$todayTime)->order('add_time desc')->select();
        if($web_lucky_cs && count($userlog) > $web_lucky_cs){
            exit(json_encode(array('yes'=>"你今天的抽奖次数已经用完",'v'=>-1)));
        }
        $web_user_bdscore=config('web_user_bdscore');//保底积分
        $web_score_bkzc=config('web_score_bkzc');
        $userInfo = Db::name("Users")->where('id',UID)->find();
        $time=time()-60*$web_score_bkzc;
        $score_bkzsum = Db::name("user_score_log")->where('uid',UID)->where('type',1)->where('addtime','gt',$time)->sum('score');//不可转积分
        if(($userInfo['score']-$score_bkzsum)>$web_user_bdscore){
            $kzjf=round($userInfo['score']-$score_bkzsum-$web_user_bdscore,2);//共可转积分
         }else{
            $kzjf=0;
         }
         $web_lucky_score=config('web_lucky_score');
         if($kzjf<$web_lucky_score){
            exit(json_encode(array('yes'=>"积分不足",'v'=>-1)));
         }
        /***************************抽奖********************************/
        $prize_arr = Db::name('lucky_prize')->where('remain_num','neq',0)->select();//找出剩下数量不为0的
        foreach ($prize_arr as $key => $val) {
            $vv = $val['odds'] / 100 * 10000 ;//几率除以100，乘以10000
            $arr[$key+1] = $vv;//抽奖从0开始循序，不允许存在空的$key
        }
        $proSum = array_sum($arr);//抽奖值字段总和
        $shang = 10000-$proSum;//没有奖的概率
        //如果不到100%，则剩下的为无奖

        $wzjlist = array(0,4,5,6,7,8);//未中奖数字
		$isj = rand(0,5);//随机生成一个0，到4之间的整形数字，包括0和4
		$sjid=$wzjlist[$isj];

		switch ($sjid) {
			case 0:
				$wzjwenzi='谢谢参与';
				break;
			case 4:
				$wzjwenzi='要加油哦';
				break;
			case 5:
				$wzjwenzi='不要灰心';
				break;
			case 6:
				$wzjwenzi='祝你好运';
				break;
			case 7:
				$wzjwenzi='再接再厉';
				break;
			case 8:
				$wzjwenzi='运气先攒着';
				break;
			default:
				# code...
				break;
		}


        if($shang){
            $arr[] = $shang;
            $prize_arr[] = array(
                'prize'=>$wzjwenzi,
                'odds' => $shang
            );
        }
        $rid = $this->get_rand($arr); //根据概率获取奖项id

        /***************************抽奖 END********************************/


        /***************************结果拼接********************************/
        $res['r'] = $rid-1;
        
        $win = isset($prize_arr[$rid-1]['id']) ? $prize_arr[$rid-1]['id']:$sjid;
        $rslog = $this->get_result($m_id, $prize_arr[$rid-1]['prize'], $win);//记录抽奖信息
        if(!$rslog){
            exit(json_encode(array('yes'=>"系统错误",'v'=>-1)));
        }

        if($win && !in_array($win,$wzjlist)) {
            //如果中奖了，减少奖品数量
            Db::name('lucky_prize')->where('id',$prize_arr[$rid - 1]['id'])->update(['remain_num' => ['exp','remain_num-1']]);//数量减一
        }
        $res['yes'] = $prize_arr[$rid-1]['prize']; //中奖项
        $res['v'] = isset($prize_arr[$rid-1]['id']) ? $prize_arr[$rid-1]['id']:$sjid ;//是否中奖
        unset($prize_arr[$rid-1]); //将中奖项从数组中剔除，剩下未中奖项
        shuffle($prize_arr); //打乱数组顺序
        for($i=0;$i<count($prize_arr);$i++){
            $pr[] = $prize_arr[$i]['prize'];
        }
        $res['no'] = $pr;//没中奖的
        exit(json_encode($res));

    }

    /**
     * 创建抽奖记录
     * @param $drawId 项目ID
     * @param $memberId 中奖会员ID
     * @param string $described 奖品描述
     * @param int $wining 是否中奖,奖品ID，未中为0
     * @return mixed
     */
    private function get_result($memberId,$described='',$wining=0){
        Db::startTrans();
        $data['member_id'] = $memberId;
        $data['result_described'] = $described;
        $data['is_win'] = $wining;
        $data['add_time'] = time();
        $res = Db::name('lucky_results')->insert($data);

         $web_lucky_score=config('web_lucky_score');

         $jiesuan=jiesuanscore(UID,strtotime("+1 day"));//结算积分
        $users_zj=up_score(UID,0,-$web_lucky_score,'转盘消费',time());//减少自己积分
 
         if($res && $jiesuan && $users_zj){
                 Db::commit(); // 提交事务
                 return true;
             }else{
                // 回滚事务
                Db::rollback();
                return false;
        }
    }

    /**
     * 抽奖算法
     * 一个几率数字的数组，数字int类型。
     * @param $proArr
     * @return int|string
     */
    private function get_rand($proArr) {
        $result = '';

        //概率数组的总概率精度
        $proSum = array_sum($proArr);

        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);

        return $result;
    }

}