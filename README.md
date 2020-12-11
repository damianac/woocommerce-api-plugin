# woocommerce-api-plugin
Fetches external API and displays it inside of Wordpress Widget and under Woocommerce 'My Account' tab

## Missing things

~~1. No cache method has been implemented~~

~~2. API requests are not handled in case of failure~~

3. API key has been added on the backend from admin panel, but has never been used in the code


## WP Cache

- Code levereges wordpress caching mechanism to store API response data. In case of API failure, cached data is displayed to the user.
