!#/usr/bin/bash
if test -f ".env"; then
	php install.php
	php product.php add cat oliver 599.99 "https://upload.wikimedia.org/wikipedia/commons/7/77/Avatar_cat.png"
	php product.php add cat nemo 531.90 "https://images.discordapp.net/avatars/479250937148604416/4aa3182984137ba559bcf26144fcf03c.png?size=512"
	php product.php add cat hermes 180.19 "https://cdn.psychologytoday.com/sites/default/files/field_blog_entry_images/2018-09/lovie.jpg"
	php product.php add dog speedy 899.99 "https://www.wantaghlibrary.org/wp-content/uploads/2016/04/cropped-dog.jpg"
	php product.php add dog jet 399.99 "https://is4-ssl.mzstatic.com/image/thumb/Purple114/v4/61/d8/c1/61d8c15a-62fa-6dac-a08d-46b21102a762/source/512x512bb.jpg"
	php product.php add dog dude 299.00 "https://i.pinimg.com/originals/ed/6f/c2/ed6fc28d25da28c73e45ed762a26bbd3.jpg"
	php product.php add dog heppu 99.90 "https://avatars.slack-edge.com/2016-10-14/91768707777_37c275ee6b9263cc3a20_512.jpg"
	php product.php add cat winona 498.40 "https://d26oc3sg82pgk3.cloudfront.net/files/media/edit/image/33545/square_thumb%403x.png"
	php product.php add horse poni 1498.40 "https://i.pinimg.com/564x/77/16/f6/7716f6d055af24a977344f0a6c5012ca.jpg"
	php product.php add horse ori 2000.00 "https://miro.medium.com/max/512/1*2b3jsZ0UxAqvltwsG7jIfw.png"
	php product.php add horse hope 3999.00 "https://secureservercdn.net/45.40.150.47/smj.2af.myftpupload.com/wp-content/uploads/2020/03/Homepage-About-Hope-Held2.jpg"
	php user.php add admin root root
	php user.php add common esa vesa
	php user.php add common loco mofo
else
	echo "Copy env_sample as .env & add username and password there first"
fi

