Project's title: Using ClamAV to scan virus online

*Requirements:
OS: Ubuntu
Software: 
- Apache2: sudo apt-get install apache2
- PHP: sudo apt-get install php libapache2-mod-php php-mcrypt php-mysql 

*Usage:
- Place two file: up_form.html and upload.php into /var/www/html

*Test
- Open browser, type http://localhost/up_form.html

=======================================================
Manual: Using Git to contribute to project

1. Install Git, download at https://git-scm.com/downloads

2. Download project at https://github.com/fonger900/ClamAv_project

3. Open project folder then right-click to open Git Bash, then enter following command: 
$ git init
$ git remote add origin https://github.com/fonger900/ClamAv_project.git

4. Change file as you wish...

5. Upload file to the Github server:
1. $ git add <file_name>
2. $ git commit -m "Some messages"
3. $ git push origin master

6. Remove file from Github server:
1. $ git rm <file_name>
2. $ git commit -m "Some messages"
3. $ git push origin master
 