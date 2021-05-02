# API Documentation

### <u>PLAYER CONTROLLER</u>

##### `api/v1/register/player`

* For player registration. Require following parameters:
>firstname \
>lastname \
>email \
>password 

##### `api/v1/update/info`

* Will update player information. May update following parameters:
>firstname
>lastname
>middleinitial
>email
>profile
>address_type
>phone
>address
>birthdate

##### `api/v1/login`

* Will login player. Require following parameters:
>email \
>password

### <u>COIN CONTROLLER</u>

##### `api/v1/coins/{id}`

* Will show coin balance of player `{player_id}`


### <u>RAFFLE CONTROLLER</u>

##### `api/v1/add/raffle-info`

* Will add new raffle entry. Require following parameters:
>raffle_name \
>raffle_desc \
>slots \

##### `api/v1/all/raffles`

* Will show all raffles available

##### `api/v1/raffles/schedule/{id}`

* Will get raffles information and schedule `{raffle_id}`

##### `api/v1/raffles/take_slot/`

* Will save selected slot. Require following parameters:
>raffle_id \
>player_id \
>price_id \
>slot_number  
* Results: `'Successful' 'Failed' 'Slot Taken'`

##### `api/v1/raffles/slots/{id}`

* Will get all slots taken in a specific raffle `{raffle_id}`

##### `api/v1/end/raffles/`

* Will update status of taken slots to 0. Require following parameters:
>raffle_id 
* Results: `'Successful' 'Failed/Already Updated'`


