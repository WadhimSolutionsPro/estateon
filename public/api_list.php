http://estate.wadhim.com/

Updated Api Parameter List



<h3>Base URL</h3> <br\>- http://estate.wadhim.com/



<h3>Register</h3> <br\>

<p> http://estate.wadhim.com/api/registeruser (POST  method)</p> <br\> 



<p><h4>parameters: </h4></p><br\>

<p>->name: username</p> <br\>

<p>->email: useremail </p><br\>

<p>->phone: phone </p><br\>

<p>->password: userpassword</p> <br\>



<p><h3>Login </h3> </p><br\>

<p>1. loginby email:</p> <br\>

<p>http://estate.wadhim.com/api/login (POST  method)</p><br\>

<p><h4>parameters: </h4></p><br\>

<p>	->email: useremail </p><br\>

<p>	->password: userpassword </p><br\>
<p>	->device_token: token </p><br\>


<p>2. loginby phone: </p><br\>

<p>http://estate.wadhim.com/api/phonelogin  (POST  method)</p> <br\>

<p><h4>parameters: </h4> </p><br\>

<p>	->phone: userphonenummber </p><br\>

<p>	->name: usernamename </p><br\>
<p>	->device_token: token </p><br\>

	

<p>3. loginby google:</p> <br\>

<p>http://estate.wadhim.com/api/sociallogin (POST  method)</p><br\>

<p><h4>parameters:</h4></p> <br\>

<p>	->loginby: 'google'</p> <br\>

<p>	->name: username </p><br\>

<p>	->avatar: profilepic </p><br\>

<p>	->email: account_email </p><br\>

<p>	->googleid: googleid </p><br\>
<p>	->device_token: token </p><br\>

<p>4. loginby apple:</p> <br\>

<p>http://estate.wadhim.com/api/sociallogin (POST  method)</p><br\>

<p><h4>parameters:</h4></p> <br\>

<p>	->loginby: 'apple'</p> <br\>

<p>	->name: username </p><br\>

<p>	->avatar: profilepic </p><br\>

<p>	->email: account_email </p><br\>

<p>	->appleid: appleid </p><br\>
<p>	->device_token: token </p><br\>



<h3>Forgot Password</h3><br\>

<p>http://estate.wadhim.com/api/forgot/password (POST  method)</p><br\>

<p><h4>parameters:</h4></p> <br\>

<p>->email: registered user email</p> <br\>



<h3>Get user Detail</h3><br\>

<p>http://estate.wadhim.com/api/user  (GET  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>

<h3>Change Password</h3><br\>

<p>http://estate.wadhim.com/api/change_password  (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>

<p>->old_password: old password</p> <br\>
<p>->new_password: New password</p> <br\>
<p>->confirm_password: same as new password</p> <br\>


<h3>Edit User</h3><br\>
<p>http://estate.wadhim.com/api/edit_user (POST  method)</p><br\>
<p>Authorization: Bearer (token)</p> <br\>

<p><h4>parameters:</h4></p> <br\>

<p>	->email: email'</p> <br\>

<p>	->name: name </p><br\>

<p>	->phone: phone </p><br\>
(note: update token after update)

<h3>Change Avatar</h3><br\>
<p>https://estate.wadhim.com/api/update_avatar (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<p>	image: (multipart image)</p> <br\>
(note: update token after update)

<h3>Change Avatar(without token)</h3><br\>
<p>https://estate.wadhim.com/api/change_avtar (POST  method)</p><br\>

<p><h4>parameters:</h4></p> <br\>
<p>	image: (multipart image)</p> <br\>
<p>	user_id: </p> <br\>
(note: update token after update)

<h3>Update Device token</h3><br\>
<p>https://estate.wadhim.com/api/update_devicetoken (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<p>	device_token: </p> <br\>

<h2>PROPERTIES APIS</h2><br\>

<h3>Vastu list</h3><br\>

<p>http://estate.wadhim.com/api/vastu  (GET  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>

<h3>Amenities list</h3><br\>

<p>http://estate.wadhim.com/api/amenities  (GET  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>

<h3>Property type list</h3><br\>

<p>http://estate.wadhim.com/api/property_types  (GET  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<h3>Property features</h3><br\>

<p>https://estate.wadhim.com/api/property_features  (GET  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>


<h3>Add property(step 1)</h3><br\>

<p>http://estate.wadhim.com/api/property_add  (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<pre>
{
type: rent,(rent, sale)
description: ads,
address: Abc,
lat: 25.957800,
lng: 80.149803,
notes: wrrervd dd
vastu: 1,
property_type:2,
amenities: [1,3] (array),
additional: [1] (array),
bedroom: 1,
bathroom:1,
balcony:1,
kitchen:1,
living_room:1,  (0 or 1)
furnished: 'unfurnished', ('unfurnished','furnished','semi_furnished')
price: 1222,
currency: rupee 
}
</pre>



<h3>Filter property</h3><br\>

<p>http://estate.wadhim.com/api/filter  (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<pre>
{
type: rent,(rent, sale)
address: Abc,
lat: 25.957800,
lng: 80.149803,
vastu: 1,
property_type:2,
amenities: [1,3] (array),
additional: [1] (array),
bedroom: 1,
bathroom:1,
balcony:1,
kitchen:1,
living_room:1,  (0 or 1)
furnished: 'unfurnished', ('unfurnished','furnished','semi_furnished')
minprice: 1222,
maxprice: 1222,
distance: 30,
sort_type: HL(HL, LH, NEW)
}
</pre>






<h3>Property List</h3><br\>

<p>https://estate.wadhim.com/api/property_list?page=1  (GET  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>

<h3>Add Property image</h3><br\>

<p>https://estate.wadhim.com/api/add_image (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<p>	image: (array)(multipart image)</p> <br\>
<p>	property_id: property id</p> <br\>


<h3>Add Property image (without Bearer)</h3><br\>

<p>https://estate.wadhim.com/api/addimage (POST  method)</p><br\>

<p><h4>parameters:</h4></p> <br\>
<p>	image: (arrat)(multipart image)</p> <br\>
<p>	property_id: property id</p> <br\>

<h3>Featured/covered Property image</h3><br\>

<p>https://estate.wadhim.com/api/featuredimage (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<p>	image_id: image id</p> <br\>
<p>	property_id: property id</p> <br\>

<h3>Nearby Properties</h3><br\>
<p>https://estate.wadhim.com/api/nearbyproperties (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>


<h3>Edit property</h3><br\>

<p>http://estate.wadhim.com/api/update_property  (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<pre>
{
type: rent,(rent, sale)
description: ads,
address: Abc,
lat: 25.957800,
lng: 80.149803,
notes: wrrervd dd
vastu: 1,
property_type:2,
amenities: [1,3] (array),
additional: [1] (array),
bedroom: 1,
bathroom:1,
balcony:1,
kitchen:1,
living_room:1,  (0 or 1)
furnished: 'unfurnished', ('unfurnished','furnished','semi_furnished')
price: 1222,
currency: rupee,
property_id: Id of property
}
</pre>
<h3>Delete Property image</h3><br\>

<p>https://estate.wadhim.com/api/delete_image (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<p>	image_id:</p> <br\>

<h3>My Properties</h3><br\>

<p>https://estate.wadhim.com/api/my_properties?page=1 (GET  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>


<h3>Hot and featured Properties</h3><br\>

<p>http://estate.wadhim.com/api/hotfeatures (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<p>	lat:</p> <br\>
<p>	lng:</p> <br\>

<h3>Like/Dislike Property</h3><br\>

<p>http://estate.wadhim.com/api/like (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<p>	property_id:</p> <br\>

<h3>Liked Property List</h3><br\>

<p>http://estate.wadhim.com/api/liked (GET  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>

<h2>Chat APIS</h2><br\>


<h3>Create Conversastion</h3><br\>
<p>https://estate.wadhim.com/api/createconversastion (POST  method)</p><br\>
<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<p>	to: id of user to who msg is send</p> <br\>
<p>	property_id: </p> <br\>

<h3>Send msg</h3><br\>
<p>https://estate.wadhim.com/api/chat (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<p>	to: id of user to who msg is send</p> <br\>
<p>	msg: </p> <br\>

<h3>Contact Agent</h3><br\>
<p>https://estate.wadhim.com/api/contactagent (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<p>	owner_id: id owner</p> <br\>
<p> property_id: property id</p> <br\>
<p> name:  </p> <br\>
<p>	phone: </p> <br\>
<p> email:  </p> <br\>
<p> type: rent (rent, sale) </p> <br\>

<h3>Chated List</h3><br\>
<p>https://estate.wadhim.com/api/chatlist (GET  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>

<h3>Chat</h3><br\>
<p>https://estate.wadhim.com/api/getchat?page=1 (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<p>	c_id: id of conversation</p> <br\>

<h3>Mark msg Read</h3><br\>
<p>https://estate.wadhim.com/api/markmsgread (POST  method)</p><br\>

<p>Authorization: Bearer (token)</p> <br\>
<p><h4>parameters:</h4></p> <br\>
<p>	c_id: id of conversation</p> <br\>













