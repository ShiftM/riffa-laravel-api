# API Documentation

### PLAYER CONTROLLER

##### `api/v1/register/player`

* For player registration. Will automatically create **ticket and coin balance = 0**. Require following parameters:
>firstname \
>lastname \
>email \
>password 

##### `api/v1/update/info`

* Will update player information. May update following parameters:
>firstname \
>lastname \
>middleinitial \
>email \
>profile \
>address_type \
>phone \
>address \
>birthdate 

##### `api/v1/login`

* Will login player. Will show **player info, coin and ticket balance**. Require following parameters:
>email \
>password

### TICKET CONTROLLER

##### `api/v1/balance/ticket/{player_id}`

* Will show ticket balance of player `{player_id}`

##### `api/v1/add/ticket/`

* Will increase ticket balance of player. Require following parameters:
>player_id \
>ticket_balance ***(tickets to be added)*** 

##### `api/v1/subtract/ticket/`

* Will decrease ticket balance of player. Require following parameters:
>player_id \
>ticket_balance ***(tickets to be subtracted)*** 

### COIN CONTROLLER

##### `api/v1/balance/coins/{player_id}`

* Will show coin balance of player `{player_id}`


### RAFFLE CONTROLLER

##### `api/v1/add/raffle`

* Will add new raffle entry. Require following parameters:
>type_id \
>prize_id \
>prize_2 ***(nullable)***\
>prize_3 ***(nullable)***\
>prize1_probability ***(nullable)***\
>prize2_probability ***(nullable)***\
>prize3_probability ***(nullable)***\
>charity_id ***(nullable)***\
>raffle_name \
>raffle_desc ***(nullable)***\
>image1 ***(nullable)***\
>image2 ***(nullable)***\
>image3 ***(nullable)***\
>slots \
>start_schedule \
>end_schedule

##### `api/v1/edit/raffle`

* Will update selected raffle entry. Require following parameters:
>raffle_id \
>type_id \
>prize_id \
>prize_2 ***(nullable)***\
>prize_3 ***(nullable)***\
>prize1_probability ***(nullable)***\
>prize2_probability ***(nullable)***\
>prize3_probability ***(nullable)***\
>charity_id ***(nullable)***\
>raffle_name \
>raffle_desc ***(nullable)***\
>image1 ***(nullable)***\
>image2 ***(nullable)***\
>image3 ***(nullable)***\
>slots \
>start_schedule \
>end_schedule

##### `api/v1/all/raffles`

* Will show all raffles available (also for admin page)
* Results: `Raffle Type, Raffle Name, Charity Name, Created_at, Status`

##### `api/v1/raffles/info/{raffle_id}`

* Will show raffles information and schedule

##### `api/v1/take/raffle/`

* Will save selected slot. Will automatically decrease **1 ticket balance**. Require following parameters:
>raffle_id \
>player_id \
>slot_number 
* Results: `'Successful' 'Failed' 'Slot Taken'`

##### `api/v1/raffles/taken/{raffle_id}`

* Will get all slots taken in a specific raffle

##### `api/v1/start/raffle/`

* Will update status of raffle to 1. Require following parameters:
>raffle_id 
* Results: `'Successful' 'Failed/Already Updated'`

##### `api/v1/end/raffle/`

* Will update status of raffle to 0, will automatically give **100 coins** to players who participated. Require following parameters:
>raffle_id 
* Results: `'Successful' 'Failed/Already Updated'`

### PRIZES CONTROLLER

##### `api/v1/all/prizes`

* Will show all prizes (also for admin)
* Results: `Name, is_available, Category Name, Description, Coin Price`

##### `api/v1/add/prize`

* Will add new prize. Require following parameters:
>name \
>category_id \
>description ***(nullable)***\
>image ***(nullable)***\
>coin_amount ***(nullable)***\

##### `api/v1/edit/prize`

* Will update selected prize. Require following parameters:
>prize_id \
>name \
>category_id \
>description ***(nullable)***\
>image ***(nullable)***\
>coin_amount ***(nullable)***\

##### `api/v1/remove/prize`

* Will update availability to 0. Require following parameters:
>prize_id \
* Results: `'Successful' 'Failed/Already Updated'`

### TRANSACTION CONTROLLER

##### `api/v1/all/transactions`

* Will show all transaction log (for admin)
* Results: `transaction_id, title, type, user, date`
