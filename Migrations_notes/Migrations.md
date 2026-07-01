# Migrations  
  
User   
    - Username  
    - Email  
    - Password  
- A user has user settings  
- A user can have a list with media  
- A user can have multiple custom statuses  
  
User settings  
    - Mode  
- User settings belong to one user  
  
Author  
    - name  
- A author can have multiple media’s  
  
Media type  
    - name  
- Media type is connected to multiple media’s  
  
Tags  
	- name  
- Media can have multiple tags an tags can belong to multiple media  
  
Media  
    - title  
    - Description  
    - published_year  
    - cover  
- Media can have multiple tags  
- Media can belong in multiple user lists  
- Media can have multiple providers  
- Media can have multiple authors  
  
Media authors  
Connection table between author and media  
  
Media tags  
Connection table between tags and media  
  
Provider  
    - Name   
    - Website   
    - Online   
  
User Media List  
Connection table between user and media to create a list of media, is also connected to to status and custom status  
  
Media provider  
Connection table between media and providers  
  
Custom status  
Connection table between user and status  
