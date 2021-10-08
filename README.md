Sample CRUD Project on Laravel Passport <br/>

1-	Register <br/><br/>
Endpoint: api/register <br/><br/>
Method: Post<br/><br/>
Parameters: <br/>
    "name":"", <br/>
    "phone":"", <br/>
    "email":"", <br/>
    "password":"", <br/>
    "password_confirmation":"" <br/><br/>
 

2-	Login <br/><br/>
Endpoint : api/login <br/><br/>
Method: Post <br/><br/>
parameter: <br/>
    "email":"", <br/>
    "password":"", <br/>

 <br/>
3-	Get user list <br/><br/>
Endpoint: api/user/list <br/><br/>
Method: Get <br/><br/>
 <br/>
4-	Update user <br/><br/>
Endpoint: api/user/update/{id} <br/><br/>
Method: Post <br/><br/>
Parameter: <br/>
    "name":"", <br/>
    "phone":"", <br/>
<br/><br/>
 

5-	Change password <br/><br/>
Endpoint: api/user/changepassword <br/><br/>
Method: Post <br/><br/>
Parameter:  <br/><br/>
    "old_password":"", <br/>
    "new_password":"", <br/>
    "confirm_password":"" <br/>
 
 <br/>
6-	Logout <br/><br/>
Endpoint: api/user/logout <br/><br/>
Method: Post <br/>
 
