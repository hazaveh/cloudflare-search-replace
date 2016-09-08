# cloudflare-search-replace

This application allows you to search within all your dns records in cloudflare account and replace a given ip address with a new one. 

The application requires you to generate an API key and place it in the includes.php file. 

Run it on a php web server. when you click on replace button it will do a search and shows all the results which will be replaced then you can confirm and let the script to do all the changes.

When you confirm the changes they will be applied in the background with an interval between cloudflare api calls to avoid your requests to be blocked by cloudflare servers.

#Used Libraries 
cocur/background-process: https://github.com/cocur/background-process
CloudFlare API - PHP: https://github.com/jamesryanbell/cloudflare
Bootstrap 3: http://getbootstrap.com
jQuery: https://jquery.com

#License
Copyright (c) 2016 Mahdi Hazaveh

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
