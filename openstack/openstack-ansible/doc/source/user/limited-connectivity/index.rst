====================================
Installing with limited connectivity
====================================

Many playbooks and roles in OpenStack-Ansible retrieve dependencies from the
public Internet by default. The example configurations assume that the deployer
provides good quality Internet connectivity via a router on the OpenStack
management network.

Deployments may encounter limited external connectivity for a number of
reasons:

- Unreliable or low bandwidth external connectivity
- Firewall rules which block external connectivity
- External connectivity required to be via HTTP or SOCKS proxies
- Architectural decisions by the deployer to isolate the OpenStack networks
- High security environments where no external connectivity is permitted

We recommend a set of practices and configuration overrides deployers can use
when running OpenStack-Ansible in network environments that block Internet
connectivity.

The options below are not mutually exclusive and may be combined if desired.

Example internet dependencies
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

- Python packages
- Distribution specific packages
- LXC container images
- Source code repositories
- GPG keys for package validation

Practice A: Mirror internet resources locally
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

You may choose to operate and maintain mirrors of OpenStack-Ansible and
OpenStack dependencies. Mirrors often provide a great deal of risk mitigation
by reducing dependencies on resources and systems outside of your direct
control. Mirrors can also provide greater stability, performance and security.

Python package repositories
---------------------------

Many packages used to run OpenStack are installed using `pip`. We advise
mirroring the PyPi package index used by `pip`. A deployer can choose to
actively mirror the entire upstream PyPi repository but this may require
a significant amount of storage. Alternatively a caching pip proxy
can be used to retain local copies of only those packages which are required.

Example OpenStack-Ansible configuration for specifying a local pip mirror or
proxy:

.. code-block:: yaml

      # Custom upstream pip index used when building repo server contents
      repo_build_pip_default_index: http://pip.example.org/simple

Distribution specific packages
------------------------------

Many software packages are installed on Ubuntu hosts using `.deb` packages.
Similar packaging mechanisms exist for other Linux distributions. We advise
mirroring the repositories that host these packages.

Upstream Ubuntu repositories to mirror for Ubuntu 16.04 LTS:

- xenial
- xenial-updates

Upstream Ubuntu repositories to mirror for Ubuntu 18.04 LTS:

- bionic
- bionic-updates

OpenStack-Ansible requires several other repositories to install specific
components such as Galera and Ceph.

Example repositories to mirror (Ubuntu target hosts):

- https://download.ceph.com/debian-luminous/
- https://www.rabbitmq.com/debian
- http://ubuntu-cloud.archive.canonical.com/ubuntu
- https://packages.erlang-solutions.com/ubuntu
- https://mirror.rackspace.com/mariadb/repo/10.1/ubuntu
- https://repo.percona.com/apt

These lists are intentionally not exhaustive and equivalents will be required
for other Linux distributions. Consult the OpenStack-Ansible playbooks and role
documentation for further repositories and the variables that may be used to
override the repository location.

LXC container images
--------------------

OpenStack-Ansible relies upon community built LXC images when building
containers for OpenStack services. Deployers may choose to create, maintain,
and host their own container images. Consult the
``openstack-ansible-lxc_container_create`` role for details on configuration
overrides for this scenario.

Source code repositories
------------------------

OpenStack-Ansible relies upon Ansible Galaxy to download Ansible roles when
bootstrapping a deployment host. Deployers may wish to mirror the dependencies
that are downloaded by the ``bootstrap-ansible.sh`` script.

Deployers can configure the script to source Ansible from an alternate Git
repository by setting the environment variable ``ANSIBLE_GIT_REPO``.

Deployers can configure the script to source Ansible role dependencies from
alternate locations by providing a custom role requirements file and specifying
the path to that file using the environment variable ``ANSIBLE_ROLE_FILE``.

Practice B: Proxy access to internet resources
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Some networks have no routed access to the Internet, or require certain
traffic to use application specific gateways such as HTTP or SOCKS proxy
servers.

Configuration can be applied to target and deployment hosts to reach public
internet resources via HTTP or SOCKS proxy server(s). OpenStack-Ansible may be
used to configure target hosts to use the proxy server(s). OpenStack-Ansible
does not provide automation for creating the proxy server(s).

Initial host deployment is outside the scope of OpenStack-Ansible and the
deployer must ensure a minimum set of proxy configuration is in place, in
particular for the system package manager.

``apt-get`` proxy configuration
-------------------------------

See `Setting up apt-get to use a http-proxy`_

.. _Setting up apt-get to use a http-proxy: https://help.ubuntu.com/community/AptGet/Howto#Setting_up_apt-get_to_use_a_http-proxy

Other proxy configuration
-------------------------

Further to this basic configuration, there are other network clients on the
target hosts which may be configured to connect via a proxy. For example:

- Most Python network modules
- `curl`
- `wget`
- `openstack`

These tools and their underlying libraries are used by Ansible itself and the
OpenStack-Ansible playbooks, so there must be a proxy configuration in place
for the playbooks to successfully access external resources.

Typically these tools read environment variables containing proxy server
settings. These environment variables can be configured in
``/etc/environment`` if required.

It is important to note that the proxy server should only be used to access
external resources, and communication between the internal components of the
OpenStack deployment should be direct, without going through the proxy.
The ``no_proxy`` environment variable is used to specify hosts that should
be reached directly without going through the proxy. These often are the hosts
in the management network.

OpenStack-Ansible provides two distinct mechanisms for configuring proxy
server settings:

#. The default configuration file suggests setting a persistent proxy
configuration on all target hosts and defines a persistent ``no_proxy``
environment variable which lists all hosts/containers' management addresses as
well as the load balancer internal/external addresses.

#. An alternative method applies proxy configuration in a transient manner
during the execution of Ansible playbooks and defines a minimum set of
management network IP addresses for ``no_proxy`` that are required for the
playbooks to succeed. These proxy settings do not persist after an Ansible
playbook run and the completed deployment does not require them in order to be
functional.

The deployer must decide which of these approaches is more suitable for the
target hosts, taking into account the following guidance:

#. Persistent proxy configuration is a standard practice and network clients on
the target hosts will be able to access external resources after deployment.

#. The deployer must ensure that a persistent proxy configuration has complete
coverage of all OpenStack management network host/containers' IP addresses in
the ``no_proxy`` environment variable. It is necessary to use a list of IP
addresses, CIDR notation is not valid for ``no_proxy``.

#. Transient proxy configuration guarantees that proxy environment variables
will not persist, ensuring direct communication between services on the
OpenStack management network after deployment. Target host network clients
such as ``wget`` will not be able to access external resources after
deployment.

#. The maximum length of ``no_proxy`` should not exceed 1024 characters due to
a fixed size buffer in the ``pam_env`` PAM module. Longer environment variables
will be truncated during deployment operations and this will lead to
unpredictable errors during or after deployment.

Once the number of hosts/containers in a deployment reaches a certain size
the length of ``no_proxy`` will exceed 1024 characters. It is then mandatory to
use the transient proxy settings which only requires a subset of the management
network IP addresses to be present in ``no_proxy`` at deployment time.

Refer to `global_environment_variables:` and
`deployment_environment_variables:` in the example `user_variables.yml` for
details of configuring persistent and transient proxy environment variables.

Deployment host proxy configuration for bootstrapping Ansible
-------------------------------------------------------------

Configure the ``bootstrap-ansible.sh`` script used to install Ansible and
Ansible role dependencies on the deployment host to use a proxy by setting the
environment variables ``HTTPS_PROXY`` or ``HTTP_PROXY``.

.. note::

   We recommend you set your ``/etc/environment`` variables with proxy
   settings before launching any scripts or playbooks to avoid failure.

For larger or complex environments a dedicated deployment host allows the most
suitable proxy configuration to be applied to both deployment and target hosts.

Considerations when proxying TLS traffic
----------------------------------------

Proxying TLS traffic often interferes with the clients ability to perform
successful validation of the certificate chain. Various configuration
variables exist within the OpenStack-Ansible playbooks and roles that allow a
deployer to ignore these validation failures. Find an example
``/etc/openstack_deploy/user_variables.yml`` configuration below:

.. code-block:: yaml

      pip_validate_certs: false
      galera_package_download_validate_certs: false

The list above is intentionally not exhaustive. Additional variables may exist
within the project and will be named using the `*_validate_certs` pattern.
Disable certificate chain validation on a case by case basis and only after
encountering failures that are known to only be caused by the proxy server(s).
