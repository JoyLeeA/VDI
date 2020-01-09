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


# SETUP : RDP Client
add-apt-repository ppa:remmina-ppa-team/remmina-next -y && wait
apt-get update && wait
apt-get install freerdp2-x11 -y && wait


# SETTING : Autostart this application(test)
mkdir ~/.config/ && wait
mkdir ~/.config/autostart/ && wait
touch ~/.config/autostart/vdi.desktop && wait
echo -e "[Desktop Entry]\nType=Application\nName=SimpleVDI\nExec=mate-terminal -e "bash -c '/home/ubuntu/start.sh;$SHELL'"\nX-GNOME-Autostart-enabled=true" > ~/usr/share/applications/vdi.desktop && wait


# Install Complete
# touch $CheckFile && wait
echo '[SYSTEM]Rebooting system(after 5 seconds).' && wait
sleep 5 && wait

reboot
