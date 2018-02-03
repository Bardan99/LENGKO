

# LENGKO

Supply Chain Management
LENGKO Restaurant

Available online at [ *sometime overload :(* ]:
 - https://lengko.gurisa.com (devices) 
 - https://lengko.gurisa.com/dashboard (employee)

> Build with laravel, love so much :)

## INSTALLATION

1. Clone this repository [LENGKO](https://github.com/gurisa/LENGKO.git) or you can easily download it.
	`git clone https://github.com/gurisa/LENGKO.git`    
2. Install trough composer:
	`composer install`	
3. Rename environment file configuration:
	`cp .ex.env .env`
4. Make sure *your connections* are good (don't forget to setup host, username, password and database name). 
Default **.env** file: 

    >     host: localhost
    >     username: root
    >     password: 
    >     database: lengko

5. **CREATE DATABASE** named **lengko** (this is up to you, but you need to set it up on .env file).
6. Import **lengko.sql** file from `/storage/db`
7. You can easily run LENGKO with artisan, do: `php artisan serve` but i recommend to set virtual host for future purpose (since it's the recommendation way). Look [how to setup virtual host here](https://www.ngaret.com/cara-mengubah-localhost-menjadi-domain-window/).

# LOGIN DETAILS

Devices (choose one)
----------
	AG001:123456
	AG002:123456
	JB001:123456
	JB002:123456

Employee (choose one)
----------
	toor:root (root authority)
	conan:conan (root authority)

# Let's rock!
**P.S:**
> If you're facing error with chiper, regenerate it: `php artisan
> key:generate`

# DOCUMENTATION
Documentations are available on `/docs` folder.

# GALLERY

![main menu](https://github.com/gurisa/LENGKO/blob/master/public/files/gallery/main-menu.png?raw=true)

![menu](https://github.com/gurisa/LENGKO/blob/master/public/files/gallery/menu.png?raw=true)

![gallery](https://github.com/gurisa/LENGKO/blob/master/public/files/gallery/gallery.png?raw=true)

![reviews](https://github.com/gurisa/LENGKO/blob/master/public/files/gallery/reviews.png?raw=true)

![dashboard](https://github.com/gurisa/LENGKO/blob/master/public/files/gallery/dashboard.png?raw=true)

![devices](https://github.com/gurisa/LENGKO/blob/master/public/files/gallery/devices.png?raw=true)

![report](https://github.com/gurisa/LENGKO/blob/master/public/files/gallery/report.png?raw=true)
# ME
>     Saya memang miskin dan bodoh;
>     Tetapi saya  tidak berencana untuk miskin dan bodoh selamanya.
>     #toor (2017)
