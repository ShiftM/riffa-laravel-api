# API Documentation

### PLAYER CONTROLLER

##### `api/v1/register/player`

* For player registration. Require following parameters:
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

* Will login player. Require following parameters:
>email \
>password

### COIN CONTROLLER

##### `api/v1/coins/{id}`

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

##### `api/v1/all/raffles`

* Will show all raffles available (also for admin page)

##### `api/v1/raffles/info/{raffle_id}`

* Will show raffles information and schedule

##### `api/v1/take/raffle/`

* Will save selected slot. Require following parameters:
>raffle_id \
>player_id \
>slot_number 
* Results: `'Successful' 'Failed' 'Slot Taken'`

##### `api/v1/raffles/taken/{raffle_id}`

* Will get all slots taken in a specific raffle

##### `api/v1/end/raffles/`

* Will update status of taken slots to 0. Require following parameters:
>raffle_id 
* Results: `'Successful' 'Failed/Already Updated'`

### PRIZES CONTROLLER

##### `api/v1/all/prizes`

* Will show all prizes (also for admin)


