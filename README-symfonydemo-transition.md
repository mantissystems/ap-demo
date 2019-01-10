Symfony Demo Application
========================
========================
git
========================
git --version

git config ; add name and email
git init
git add -A
git status
git config --list
git push origin master
git commit -m "05-01-2019"
git diff
git reset api

========================

The "Symfony Demo Application" is a reference application created to show how
to develop applications following the [Symfony Best Practices][1].

Requirements
------------

  * PHP 7.1.3 or higher;
  * PDO-SQLite PHP extension enabled;
  * and the [usual Symfony application requirements][2].

Installation
------------
composer create-project symfony/symfony-demo
browser at <http://localhost:8000>:

cd symfony-demo/
$ php bin/console server:run

Execute this command to run tests:

$ cd symfony-demo/
$ ./bin/phpunit

[1]: https://symfony.com/doc/current/best_practices/index.html
[2]: https://symfony.com/doc/current/reference/requirements.html
[3]: https://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html

AANPASSINGEN AAN SYMFONY-DEMO
-- create from database
        bin/console doctrine:mapping:import 'App\Entity' annotation --path=src/Entit   
         php bin/console make:entity --regenerate App         

 updated: src/Entity/MigrationVersions.php
 no change: src/Entity/Tag.php
 no change: src/Entity/User.php

 updated: src/Entity/SymfonyDemoComment.php
 no change: src/Entity/Comment.php
 updated: src/Entity/SymfonyDemoPost.php
 updated: src/Entity/SymfonyDemoTag.php
 updated: src/Entity/SymfonyDemoUser.php


php  bin/console doctrine:database:drop --force
php  bin/console doctrine:database:create   ;creates database with name from dotenv
php  bin/console doctrine:schema:create  ;DO NOT IN PRODUCTION

Dev-environment and additions to Symfony-demo package

    2  /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
   10  cd symfony-demo
   50  cdclub
   53  htop
   56  cddemo
  115  composer require-dev
  121  sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=4096
  122  composer update
  123  sudo nano /etc/fstab

  127  sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=4096
  130  sudo chmod 0600 swapfile
  131  sudo mkswap swapfile
  132  sudo swapon
  133  sudo nano /etc/fstab

  sudo chmod 0600 swapfile
  composer create-project symfony/website-skeleton mijnproject
  composer create-project symfony/skeleton mijnconsole-app

 ===================================================
LINUX commands
php bin/console config:dump-reference framework
cd symfony4

  197  installed
  198  yay avahi

  200  systemctl status avahi-deamon
  203  nano .bashrc
  204  avahi-browse -alr
  systemctl enable avahi-daemon

  230  yay cifs
  231  sudo mount -t cifs //192.168.0.21/Time\ Capsule -o username=MantisTC,password=molenveld,sec=ntlm /mnt/MantisTC
  232  sudo mount -t cifs //192.168.0.21/Time\ Capsule -o username=MantisTC,password=molenveld,sec=ntlm,vers=1.0 /mnt/MantisTC
  233  mkdir /mnt/MantisRoom
  234  sudo mkdir /mnt/MantisRoom
  235  sudo mount -t cifs //192.168.0.122/Time\ Capsule -o 
  254  sudo mount -t cifs //192.168.0.21/Time\ Capsule -o username=MantisTC,password=molenveld,sec=ntlm,vers=1.0 /mnt/MantisTC
  255  mkdir /mnt/MantisRoom
  256  sudo mkdir /mnt/MantisRoom
  353  cd symfony4/
  354  cd symfony-demo/

  359  composer require --dev doctrine/doctrine-fixtures-bundle
  360  htop
  362  php bin/console doctrine:fixtures:load
  373  nano mount.txt

===================================
composer dump-autoload
    composer req maker
    php bin/console make:controller Import
php bin/console make:controller Utilities
php bin/console make:controller Matrix
php bin/console make:entity Actiontag
php bin/console make:entity Actionpost

php bin/console make:entity Actionpost; and add fields when asked force
php bin/console make:entity --regenerate ; will create all needed getters and setters 
php bin/console doctrine:schema:update --force
composer require league/csv:^8.0 
composer require symfony/finder
composer require symfony/asset (weet niet zeker)
composer require encore
composer require symfony/webpack-encore-bundle
composer require friendsofsymfony/jsrouting-bundle
in base.html.twig
in block javascript
				<script src="{{ asset('thom/dashy.js') }}"></script>
				<script src="{{ asset('thom/index.js') }}"></script>

in homepage.html.twig
	<link rel="stylesheet" href="{{ asset('thom/css/dashy.css') }}">
    
	php bin/console fos:js-routing:debug
	remark:put assetfiles in public or web for unrestricted access
	
	run php bin/console assets:install --symlink to install present assets in public/bundles
	http://127.0.0.1:8000/nl/admin/post/new
===================================

  425  composer req var-dumper
  427  php bin/console doctrine:migrations:migrate
  428  php bin/console doctrine:migrations:diff
  430  php bin/console doctrine:schedule:update
  431  php bin/console make:migration
  432  php bin/console make:entity Inloadfiles
php bin/console make:entity Teams
php bin/console make:entity Mapping
===================================
ONTWIKKELING APP
===================================
===================================
uninstall package and remove entry from config/bundle.php if needed
== modify app fixtures
== add teams data
HOMEPAGE
backup homepage.html.twig in templates; default;blog
backup base.html.twig
backup    translations/messages+intl-icu.nl.xlf
------------------------
            <trans-unit id="action.browse_admin">
                <source>action.browse_admin</source>
                <target>Beheer</target>
            </trans-unit>
------------------------
              <trans-unit id="action.import">
                <source>action.import</source>
                <target>Adapter</target>
            </trans-unit>
------------------------
                <source>help.browse_app</source>
                <target><![CDATA[<strong>APP</strong> ]]></target>
            </trans-unit>
                <source>help.browse_admin</source>
                <target><![CDATA[<strong>Beheer</strong>]]></target>
            </trans-unit>
------------------------
buttongroup
templates/import/index
templates/default
IMPORTADAPTER
return adapterindex.html.twig(from candidatefiles.html.twig)

use League\Csv\Reader;
use League\Csv\Statement;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
create file-links via finder and reader
<li>Your data at <code><a href="{{ file.sourcefile|file_link(0) }}">{{file.sourcefile}}</a></code></li>         
map Thom in public
-containing dashy.js and index.js
===================================

  443  history > mantis

//////////////////===============================
//CheckRequirementsSubscriber
//getDoctrine_fixturesLoadCommandService

in homepage.html.twig 
     <div id="dashboard2"></div>

                    </p>
                </div>
            </div>
        </div>
   <script src="{{ asset('thom/dashy.js') }}"></script>
        <script src="{{ asset('thom/index.js') }}"></script>
    {% endblock %}
        {% block javascripts %}
///////////////

===================================
MODIFY  APP FIXTURES
===================================
===================================
make entity tag
copy content of symfony-demo-tag in new entity tag
make entity actionpost
copy content of symfony-demo-post in new entity actionpost
in entity actionpost.php
 public function setAuthor(?User $author): void
    {
        $this->author = 1;//$author; omdat author als object in het argument wordt gezet
    }

        $this->loadactiontag($manager);
		    private function loadactiontag(ObjectManager $manager) {
        foreach ($this->getTagData() as $index => $name) {
            $tag = new Actiontag();
            $tag->setName($name);
        $this->loadActionpost($manager);
===================================
MODIFY  APP
===================================
via public/index.php
templatecontroller
default/homepage.html.twig
/templates/base.html.twig => /template/mantis.html.twig

public function templateAction(string $template, int $maxAge = null, int $sharedAge = null, bool $private = null): Response

webpack.config.js
===================================
in webpack.config.js
	    .addEntry('js/mantis', './assets/js/dashy.js')
		.addEntry('js/mantis', './assets/js/index.js')        
in index.js
    }, {
        name: 'Maintenance apps',
        children: [
            { title: 'Beginpagina', url: '/nl', icon: 'plug', color: 'orange' },
            { title: 'Beheerpaneel', url: '/nl/admin/post', icon: 'list', color: 'lightgreen' }
        ]
    }, {
	in mantis.html.twig
		
{% block main %}
    <body>
          <div id="dashboard"></div>
</body>

{% block javascripts %}
   {{ parent() }}
       <script src="{{ asset('/js/mantis.js') }}"></script>
       <script src="{{ asset('/js/dashy.js') }}"></script>       
	  <script src="{{ asset('/js/index.js') }}"></script>
{% endblock %}
{% block stylesheets %}
   {{ parent() }}
	  <link rel="stylesheet" href="/scss/dashy.css">
{% endblock %}

