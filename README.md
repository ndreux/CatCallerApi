# Catcaller API

[ ![Codeship Status for ndreux/catcaller-api](https://app.codeship.com/projects/3fab0d40-9192-0135-fd2e-461e903ff2c4/status?branch=master)](https://app.codeship.com/projects/250496)

To install the project, follow the instructions given here : https://api-platform.com/docs/distribution/

## Configuration

### Create your jwt keys

```
mkdir -p var/jwt
openssl genrsa -out var/jwt/private.pem
openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
```

## Usage

To access the main functions, you have to be authenticated.
To do so :

### Create an account

Send a `POST` request with the following JSON body :

{
  "email": "youremail@mail.com",
  "plainPassword": "password"
}

Ex : https://paw.pt/cJAWOIGv

### Request a token

Once you have an account, you can request a token.

Send a `POST` request 

```
curl -X POST http://127.0.0.1:8000/login_check -d _username=youremail@mail.com -d _password=password
```

You should obtain a response like this

```
{"token":"eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xFX1VTRVIiXSwidXNlcm5hbWUiOiJ5b3VyZW1haWxAbWFpbC5jb20iLCJpYXQiOjE1MDg1MDU5OTcsImV4cCI6MTUwODUwOTU5N30.QGSJaxjNhY09dxoFBPT0jB9wQGbYsxJb2LwJJbljMi-IUsitsdvUKLxJENel2vQbpvhJzi-z8fxTlb1sFYrI6Rj4w4GKdDt9vA6GlmcdAPsVvbaGRMKAV7xKoPvhUPvbGCVIWSH7D4mCP91JROC8KZg6DW2YotBTwS72SDzmj3NfiS4sPJlKSvRTmjWeZu9PjRvefudMzjSU2mXvfQJ_KZQ3R1EI_G9WHcRDsWciQKeFDgInBrwY611Apwhgm1RlfdwuSOas6qP4YeIMf4aC-7h-Q4RLjP7fDtcMi7Q99q4s4pn5h0J9tkgCu0GtOHtpJB5dIc_-1CKcl816aLsVEd5zE1COYD2claSOeymEAvuRTmry-mETmcrY5lXbFjJM79EuqzODwRFReLxSjukA0W4l5u85XPNIRWmzeWS_ut3XbW8o7gL83yQvXUudlhvPDZ1kkz2Clst5GjOTTdBEJ0bu3yjjy79BgC5QKspyf_AszkGLvqzKyEw_r9dx-kPdZd2G3gB2h6DcIRIChWKS573T2HeexRQvsNyJMv4CQQ4x7IYjGr-g6ESKdNnkAE9FNyluT_9jvxcuscBknZCmEeBvoR-PcxtTvitpu9_w_7wopb854xxQlduKLk6DUXcowl-XPSmovGzEw9dYBZ7hm_dvBn4lw22yhkr-3lwmqaM"}
``` 

Ex : https://paw.pt/cJAXFR0b

### Pass the token in the request headers 

For each request you make, you have to pass this token in order to be authenticated.
By default only the authorization header mode is enabled : `Authorization: Bearer {token}`
