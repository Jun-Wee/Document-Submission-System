Linux Copy Project folders from one directory to another
********************************************************
[Project -> html]
copy all files: cp * ../../../../var/www/html
copy folder: cp -R folder_name ../../../../var/www/html
../../../../var/www/html

[html -> Project]
../../../root/GitHub/Document-Submission-System/Project
*******************************************************

Linux Delete/Remove file
*******************************************************
rm filename
*******************************************************

Linux Create new file
*******************************************************
cat > sourcefilename
paste-your-file-content-here

Ctrl-D: Save your new file content
*******************************************************

SSH Commands:
sudo su
yum update -y
yum install httpd -y
chkconfig httpd on
cd /var/www/html
aws s3 sync s3://remote_S3_bucket local_directory
service httpd start

GitHub Token Expires 21/August/2022
*******************************************************
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
*******************************************************

Install MySQL to EC2 instance
*******************************************************
yum install sql
*******************************************************

Connect RDS SQL from EC2 instance
*******************************************************
cmd: mysql -h documentsubmissionsystem.c2tnrfke8bpv.us-east-1.rds.amazonaws.com -P 3306 -u admin -p
username: admin
password: documentsubmissionsystem

Setup Apache Command on CentOS 7
*******************************************************
Method 1: Restart Apache Server Using Systemctl Command
sudo systemctl restart httpd.service

To start the Apache service:
sudo systemctl start httpd.service

Stop the Apache service with:
sudo systemctl stop httpd.service

Force Apache to refresh the configuration files:
sudo systemctl reload httpd.service

Set Apache to run when the system boots:
sudo systemctl enable httpd.service

Prevent Apache from loading when the system boots:
sudo systemctl disable httpd.service
*******************************************************

install PHP and HTTP Apache
*******************************************************
https://yehiweb.com/install-php-7-4-7-3-or-7-2-on-aws-ec2-instance-guide/