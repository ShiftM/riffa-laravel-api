# API Documentation

### PLAYER CONTROLLER

##### `api/v1/register/player`

* For player registration

##### `api/v1/update/info`

* Will update player information

##### `api/v1/login`

* Will login player

### COIN CONTROLLER

##### `api/v1/coins/{id}`

* Will show coin balance of player `{player_id}`


### RAFFLE CONTROLLER

##### `api/v1/raffles/`

* Will show all raffles available

##### `api/v1/raffles/schedule/{id}`

* Will get raffles information and schedule `{raffle_id}`

##### `api/v1/raffles/slots/{id}`

* Will get all slots taken in a specific raffle `{raffle_id}`

##### `api/v1/raffles/take_slot/`

* Will save selected slot. Require following parameters:
>raffle_id \
>player_id \
>price_id \
>slot_number 
* Results: `'Successful' 'Failed' 'Slot Taken'`

##### `api/v1/raffles/end/`

* Will update status of taken slots to 0. Require following parameters:
>raffle_id
