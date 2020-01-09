#!/bin/bash

TESTMODE=true

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



# SETTING : Change repository(archive.ubuntu.com -> mirror.kakao.com)
sed -i 's|arhive.ubuntu.com|mirror.kakao.com|g' /etc/apt/sources.list && wait

# SETTING : Update repository
apt-get update && wait

# SETUP : Install required modules
if [ ! $TESTMODE == 'true' ]; then
    apt-get install wget build-essential -y && wait
fi

# SETUP : Install ubuntu-desktop
apt-get install --no-install-recommends ubuntu-desktop -y && wait

# SETTING : Change root password
echo 'root:VDIProject!@1234' | chpasswd && wait

# SETTING : Auto login setting
sed -i.bak -e '3d' /etc/pam.d/gdm-password && wait
sed -i.bak -e '3d' /etc/pam.d/gdm-autologin && wait
echo -e "[daemon]\nAutomaticLoginEnable=true\nAutomaticLogin=root\n\n[security]\nAllowRoot=true\n\n[xdmcp]\n\n[chooser]\n\n[debug]\n" > /etc/gdm3/custom.conf && wait

# SETUP : RDP Client
add-apt-repository ppa:remmina-ppa-team/remmina-next -y && wait
apt-get update && wait
apt-get install freerdp2-x11 -y && wait

echo '[SYSTEM]Install complete.' && wait

# SETTING : Autostart this application(test)
mkdir ~/.config/ && wait
mkdir ~/.config/autostart/ && wait
touch ~/.config/autostart/vdi.desktop && wait
echo -e "[Desktop Entry]\nType=Application\nName=SimpleVDI\nExec=gnome-terminal -e "bash -c '/home/ubuntu/start.sh;$SHELL'"\nX-GNOME-Autostart-enabled=true" > ~/.config/autostart/vdi.desktop && wait

# SETTING : [20190603][BUG]mesg: ttyname failed
echo -e "tty -s && mesg n" > /root/.profile && wait

# Install Complete
# touch $CheckFile && wait
echo '[SYSTEM]Rebooting system(after 5 seconds).' && wait
sleep 5 && wait

reboot
