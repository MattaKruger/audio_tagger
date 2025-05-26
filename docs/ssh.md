# SSH Remote Access Setup Guide

## SSH Server Configuration

### Linux Systems
Install and enable SSH server:
- Debian/Ubuntu: `sudo apt install openssh-server`
- Red Hat/CentOS: `sudo yum install openssh-server`
- Enable and start: `sudo systemctl enable ssh && sudo systemctl start ssh`

### Windows Systems
Install OpenSSH Server through Windows Features or PowerShell:
```
Add-WindowsCapability -Online -Name OpenSSH.Server
```

### macOS Systems
Enable Remote Login in System Preferences > Sharing

## Router Port Forwarding

1. Access router admin interface (typically 192.168.1.1 or 192.168.0.1)
2. Navigate to port forwarding section
3. Create rule: External port → Home computer internal IP:22
4. Find home computer's local IP using `ip addr` (Linux), `ipconfig` (Windows), or Network settings (macOS)
5. Note your public IP address from whatismyipaddress.com

## Security Configuration

### Change Default SSH Port
Edit `/etc/ssh/sshd_config` and modify:
```
Port 2222
```
Restart SSH service and update router port forwarding rule accordingly.

### SSH Key Authentication
Generate key pair on laptop:
```
ssh-keygen -t rsa -b 4096
```
Copy public key to home computer's `~/.ssh/authorized_keys`

### Additional Security
- Disable root login in sshd_config
- Install fail2ban for brute force protection
- Configure firewall to allow only SSH port

## Basic SSH Connection
```
ssh username@your-public-ip -p port-number
```

## Desktop Environment Access

### VNC over SSH Tunnel
1. Install VNC server on home computer (TigerVNC, TightVNC, x11vnc)
2. Configure VNC server for desktop session
3. Create SSH tunnel: `ssh -L 5901:localhost:5901 username@your-home-ip`
4. Connect VNC client to `localhost:5901`

### X11 Forwarding
Connect with X11 forwarding enabled:
```
ssh -X username@your-home-ip
```
Run individual GUI applications that display on local screen.

### RDP via SSH Tunnel
1. Install xrdp on Linux home computer
2. Create tunnel: `ssh -L 3389:localhost:3389 username@your-home-ip`
3. Connect RDP client to `localhost:3389`

### XPRA Persistent Sessions
1. Install XPRA on both computers
2. Start session on home computer: `xpra start :100`
3. Connect remotely: `xpra attach ssh:username@your-home-ip:100`

### NoMachine NX
Commercial solution with optimized performance for remote desktop access.

## Dynamic DNS (Optional)
Consider services like No-IP or DuckDNS if your ISP assigns dynamic IP addresses.