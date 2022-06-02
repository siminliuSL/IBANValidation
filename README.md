# IBANValidation

- To build an image

docker buildx build --platform <platform> -t ibanvalidation .


- To use the API

GET http://<host>:9090/api/iban/{iban}
   
1 is returned if the IBAN number is valid. Otherwise 0 is returned.
