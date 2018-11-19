```
cp app.db var/app.db
```

import `interview-backend-test-postman.json` into postman.

#Tasks

1.  Create user register and login and then user authentication for APIs:

    1.  create a controller with two `login` and `register` actions. You must add a `cellphone` column
        to `User` entity. On `login` endpoint you must generate an access token and send that to the user in 
        response.

    2.  Create an authenticator to authenticate users by the access token. Authentication must be stateless.
   
2.  Create an endpoint to submit an order by authenticated users.

    1.  Create `Order` entity with these columns:

        * vendor_id
        * created_at
        * updated_at
        * user_id
        * status

    2.  Orders must have some products of the vendor is assigned to. So you need to create
        a many-to-many relationship between `Product` and `Order` entities.

    3.  Create a controller to submit order
        
3.  Send sms to the user after order been submitted. We need to have two sms providers to 
    be able to switch between them. Each sms provider must have own service for sending sms.
    
4.  [optional task] Add an authorization layer for checking access to endpoints. For example only admin
    users (users with `ROLE_ADMIN` role) can create and modify restaurants and products.
    
5.  [optional task] Add endpoints to accept and reject orders. This endpoint must be accessible by admin users.    