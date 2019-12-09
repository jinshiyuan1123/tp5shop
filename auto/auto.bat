@echo off
z:
cd z:\wwwroot\zsh.ruishengkj.net
set num=1
:chongfu
if %num% equ 60 exit
z:\BtSoft\WebSoft\php\5.5\php.exe think auto
set /a num+=1
timeout /t 1
goto chongfu