#!/usr/bin/env bash
# Copyright 2014, Rackspace US, Inc.
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
#
# (c) 2014, Kevin Carter <kevin.carter@rackspace.com>

# OpenStack wrapper tool to ease the use of ansible with multiple variable files.

export PATH="/opt/ansible-runtime/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:${PATH}"
export OSA_VERSION="CURRENT_OSA_VERSION"

function info {
    if [ "${ANSIBLE_NOCOLOR:-0}" -eq "1" ]; then
      echo -e "${@}"
    else
      echo -e "\e[0;35m${@}\e[0m"
    fi
}

# Figure out which Ansible binary was executed
RUN_CMD=$(basename ${0})

# Apply the OpenStack-Ansible configuration selectively.
if [[ "${PWD}" == *"OSA_CLONE_DIR"* ]] || [ "${RUN_CMD}" == "openstack-ansible" ]; then

  # Source the Ansible configuration.
  . /usr/local/bin/openstack-ansible.rc

  # Load userspace group vars
  if [[ -d /etc/openstack_deploy/group_vars || -d /etc/openstack_deploy/host_vars ]]; then
     if [[ ! -f /etc/openstack_deploy/inventory.ini ]]; then
        echo '[all]' > /etc/openstack_deploy/inventory.ini
     fi
  fi

  # Check whether there are any user configuration files
  if ls -1 /etc/openstack_deploy/user_*.yml &> /dev/null; then

    # Discover the variable files.
    VAR1="$(for i in $(ls /etc/openstack_deploy/user_*.yml); do echo -ne "-e @$i "; done)"

    # Provide information on the discovered variables.
    info "Variable files: \"${VAR1}\""

  fi

else

  # If you're not executing 'openstack-ansible' and are
  # not in the OSA git clone root, then do not source
  # the configuration and do not add extra vars.
  VAR1=""

fi

# Execute the Ansible command.
if [ "${RUN_CMD}" == "openstack-ansible" ] || [ "${RUN_CMD}" == "ansible-playbook" ]; then
  ansible-playbook "${@}" ${VAR1}
  PLAYBOOK_RC="$?"
  if [[ "${PLAYBOOK_RC}" -ne "0" ]]; then
    echo -e "\nEXIT NOTICE [Playbook execution failure] **************************************"
  else
    echo -e "\nEXIT NOTICE [Playbook execution success] **************************************"
  fi
  echo "==============================================================================="
  exit "${PLAYBOOK_RC}"
else
  ${RUN_CMD} "${@}"
fi
