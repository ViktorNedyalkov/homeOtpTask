# homeOtpTask

## Initial instructions for apache Vhosts
1. Import the databaseCreationScript.sql, which will create all of the necessary tables.
2. For apache setup I used a virtual host
```
<VirtualHost local.otpTask.com:80>
	ServerAdmin webmaster@localhost
	ServerName local.otpTask.com
	ServerAlias local.otpTask.com 
	DocumentRoot {absolutepath_to_folder}

	<Directory {absolute_path_to_folder}>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>
</VirtualHost>
```
3. Add "127.0.0.1 local.otpTask.com" to your hosts files
# Database Schema

<img src="https://raw.githubusercontent.com/ViktorNedyalkov/homeOtpTask/master/databseSchema.png" alt="Database Schema">