# IBANValidation

- To build an image

docker buildx build --platform <platform> -t ibanvalidation .


- To use the API

GET <BaseURL>/api/iban/{iban}
   
1 is returned if the IBAN number is valid. Otherwise 0 is returned.
