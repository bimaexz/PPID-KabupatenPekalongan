ALTER TABLE `#__gridbox_store_product_data` ADD `min` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_customer_info` CHANGE `title` `title` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_customer_info` CHANGE `type` `type` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_customer_info` CHANGE `options` `options` text;
ALTER TABLE `#__gridbox_store_cart_products` CHANGE `cart_id` `cart_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_cart_products` CHANGE `product_id` `product_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_cart_products` CHANGE `variation` `variation` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_cart_products` CHANGE `quantity` `quantity` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_orders_status_history` CHANGE `order_id` `order_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_orders_status_history` CHANGE `user_id` `user_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_orders_status_history` CHANGE `date` `date` datetime;
ALTER TABLE `#__gridbox_store_orders_status_history` CHANGE `comment` `comment` text;
ALTER TABLE `#__gridbox_store_orders` CHANGE `date` `date` datetime;
ALTER TABLE `#__gridbox_store_orders` CHANGE `cart_id` `cart_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_orders` CHANGE `user_id` `user_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_orders` CHANGE `subtotal` `subtotal` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_orders` CHANGE `tax` `tax` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_orders` CHANGE `total` `total` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_orders` CHANGE `currency_symbol` `currency_symbol` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_orders` CHANGE `currency_position` `currency_position` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_orders` CHANGE `params` `params` text;
ALTER TABLE `#__gridbox_store_orders_discount` CHANGE `order_id` `order_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_orders_discount` CHANGE `promo_id` `promo_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_orders_discount` CHANGE `title` `title` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_orders_discount` CHANGE `code` `code` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_orders_shipping` CHANGE `order_id` `order_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_orders_shipping` CHANGE `shipping_id` `shipping_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_orders_shipping` CHANGE `title` `title` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_orders_shipping` CHANGE `price` `price` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_orders_shipping` CHANGE `tax` `tax` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_orders_payment` CHANGE `order_id` `order_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_orders_payment` CHANGE `title` `title` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_orders_payment` CHANGE `type` `type` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_orders_payment` CHANGE `payment_id` `payment_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_order_customer_info` CHANGE `order_id` `order_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_order_customer_info` CHANGE `customer_id` `customer_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_order_customer_info` CHANGE `title` `title` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_order_customer_info` CHANGE `type` `type` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_order_customer_info` CHANGE `value` `value` text;
ALTER TABLE `#__gridbox_store_order_customer_info` CHANGE `options` `options` text;
ALTER TABLE `#__gridbox_store_order_products` CHANGE `order_id` `order_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_order_products` CHANGE `title` `title` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_order_products` CHANGE `image` `image` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_order_products` CHANGE `variation` `variation` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_order_products` CHANGE `quantity` `quantity` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_order_products` CHANGE `price` `price` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_order_products` CHANGE `sale_price` `sale_price` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_order_products` CHANGE `sku` `sku` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_order_license` CHANGE `order_id` `order_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_order_product_variations` CHANGE `product_id` `product_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_order_product_variations` CHANGE `order_id` `order_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_order_product_variations` CHANGE `type` `type` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_order_product_variations` CHANGE `title` `title` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_order_product_variations` CHANGE `value` `value` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_order_product_variations` CHANGE `color` `color` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_order_product_variations` CHANGE `image` `image` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_user_info` CHANGE `user_id` `user_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_user_info` CHANGE `customer_id` `customer_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_user_info` CHANGE `value` `value` text;
ALTER TABLE `#__gridbox_store_wishlist_products` CHANGE `wishlist_id` `wishlist_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_wishlist_products` CHANGE `product_id` `product_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_wishlist_products` CHANGE `variation` `variation` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_badges` CHANGE `title` `title` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_badges` CHANGE `color` `color` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_badges` CHANGE `type` `type` varchar(255) NOT NULL DEFAULT "";
ALTER TABLE `#__gridbox_store_badges_map` CHANGE `product_id` `product_id` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__gridbox_store_badges_map` CHANGE `badge_id` `badge_id` int(11) NOT NULL DEFAULT 0;