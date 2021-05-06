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

* Will increase coin balance of player. Require following parameters:
>player_id \
>description \
>ticket_balance ***(tickets to be added)*** 

##### `api/v1/subtract/ticket/`

* Will decrease coin balance of player. Require following parameters:
>player_id \
>description \
>ticket_balance ***(tickets to be subtracted)*** 

### COIN CONTROLLER

##### `api/v1/balance/coins/{player_id}`

* Will show coin balance of player `{player_id}`


### RAFFLE CONTROLLER

##### `api/v1/add/raffle`

* Will add new raffle entry. Require following parameters:
>prize_id \
>charity_id ***(nullable)***\
>raffle_name \
>raffle_desc ***(nullable)***\
>image ***(nullable)***\
>slots \
>slot_price \
>start_schedule \
>end_schedule

##### `api/v1/edit/raffle`

* Will update selected raffle entry. Require following parameters:
>raffle_id \
>prize_id \
>charity_id ***(nullable)***\
>raffle_name \
>raffle_desc ***(nullable)***\
>image ***(nullable)***\
>slots \
>slot_price \
>start_schedule \
>end_schedule

##### `api/v1/all/raffles`

* Will show all raffles available (also for admin page)

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

##### `api/v1/end/raffles/`

* Will update status of taken slots to 0, will automatically give **100 coins** to players who participated. Require following parameters:
>raffle_id 
* Results: `'Successful' 'Failed/Already Updated'`

### PRIZES CONTROLLER

##### `api/v1/all/prizes`

* Will show all prizes (also for admin)


