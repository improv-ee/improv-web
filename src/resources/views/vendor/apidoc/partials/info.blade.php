# Info

Welcome to the generated API reference.
@if($showPostmanCollectionButton)
[Get Postman Collection]({{url($outputPath.'/collection.json')}})
@endif

Please note the API is currently a preview only. We give no guarantees on uptime or API interface spec (consider the v1 API unversioned).

# Getting access to the API

The API is open for everyone to use. The base URL for the API is `https://api.improv.ee/`.
The API is versioned with URI prefixes, so `https://api.improv.ee/v1/` would be API version 1.

## Obtaining the access token

You need a registrered user account on [improv.ee](https://improv.ee) in order to access the API.
Go to your user profile settings, your API token is listed there.

The API has both public and authenticated endpoints. Public endpoints are read-only. All authenticated endpoints
must include a `Authorization: Bearer <your-token>` header in the request.
