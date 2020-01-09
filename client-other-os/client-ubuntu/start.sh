#!/bin/bash

# SETTING : Power saving(blank screen)
gsettings set org.gnome.desktop.session idle-delay 0 && wait

# SETTING : Automatic suspend
sudo systemctl mask sleep.target suspend.target hibernate.target hybrid-sleep.target && wait

# SETTING : Automatic screen lock
gsettings set org.gnome.desktop.screensaver lock-enabled false && wait

# Config 파일이 존재하지 않으면 생성을 진행한다.
if [ ! -f "/home/ubuntu/vdi.config" ]; then
    while true; do
        printf "# Input your license key : " && wait
        read input_license && wait

        # result = $(curl ~~~input_license)
        host_result='vdi-client.nerd.kim' && wait
        host_name='KONKUK-Test-License' && wait

        if [ ! -z "$host_result" ]; then
            printf "[INFO]Your host name is '$host_name'.\n" && wait
			break && wait
        else
            printf "No license found.\n" && wait
        fi
	done

    printf "# Select OS - [W]indows, [U]buntu : " && wait
    read input_os && wait

    touch /home/ubungu/vdi.config && wait
    echo -e "host=$host_result\nname=$host_name\nport=3393" > /home/ubuntu/vdi.config && wait

    # sleep 5 && wait

	reboot

else

	# Get config file
	. /home/ubuntu/vdi.config && wait

	# Start RDP program
    # /usb:id,dev:
	echo Y | xfreerdp /v:$host /port:$port /u:'Administrator' /compression /gfx /rfx /p:'VDIProject!@1234' /f /sound +auto-reconnect && wait

	# OpenStack instance에 초기화 명령을 내린다.

	# Shutdown client
	# shutdown -h now && wait
fi
