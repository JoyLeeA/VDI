#!/bin/bash


### Are you a root user? 
if [[ $EUID -ne 0 ]]; then
    echo "[SYSTEM]You must be a root user." 2>&1
    exit 1
fi


### Is network connection ok?
while true; do
    echo -e "GET http://google.com HTTP/1.0\n\n" | nc google.com 80 > /dev/null 2>&1

    if [ $? -eq 0 ]; then
        break
    else
        echo "[SYSTEM]We could not verify your internet connection. Try again in 5 seconds." && wait
        sleep 5 && wait
    fi
done

echo "[SYSTEM]Internet connection is verified!" && wait
 

# Update repository endpoint
sed -i 's|raspbian.raspberrypi.org|ftp.kaist.ac.kr\/raspbian|g' /etc/apt/sources.list && wait


# Update repository
apt-get update && wait


# Upgrade modules
apt-get upgrade -y && wait


# Delete newline from /boot/cmdline.txt
touch __temp__
tr -d '\n\r' < /boot/cmdline.txt > __temp__
rm -rf /boot/cmdline.txt
cp -rf __temp__ /boot/cmdline.txt
rm -rf __temp__

# Disabled overscan(for screen no margin)
sed -i 's|disable_overscan=0|disable_overscan=1|g' /boot/config.txt && wait


# Disabled splash
sed -i 's|\ splash\ |\ |g' /boot/cmdline.txt && wait
echo -ne ' logo.nologo' >> /boot/cmdline.txt && wait


# Change startup logo
# apt install fbi insserv && wait
# cp -rf /home/pi/client/modules/asplashscreen /etc/init.d/asplashscreen && wait
# chmod a+x /etc/init.d/asplashscreen && wait
# insserv /etc/init.d/asplashscreen && wait


# Setup startup script
rm -rf /home/pi/.config/lxsession/LXDE-pi/autostart && wait
mkdir /home/pi/.config/lxsession/ && wait
mkdir /home/pi/.config/lxsession/LXDE-pi/ && wait
touch /home/pi/.config/lxsession/LXDE-pi/autostart && wait
cp -rf /home/pi/client/modules/autostart-before-install /home/pi/.config/lxsession/LXDE-pi/autostart && wait


# Reboot
echo '[SYSTEM]Rebooting system(after 5 seconds).' && wait
sleep 5 && wait
reboot
