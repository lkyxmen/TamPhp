DROP TABLE IF EXISTS `cnt_options`;
CREATE TABLE IF NOT EXISTS `cnt_options` (
    `option_key` varchar(50) NOT NULL,
    `option_value` text,
  PRIMARY KEY  (`option_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_onlines`;
CREATE TABLE IF NOT EXISTS `cnt_onlines` (
    `id` bigint(20) unsigned NOT NULL auto_increment,
    `online_time` int(10) NOT NULL,
    `online_ss` varchar(40) NOT NULL,
    `online_user` bigint(20) NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `cnt_templates`;
CREATE TABLE IF NOT EXISTS `cnt_templates` (
    `id` tinyint(2) NOT NULL auto_increment,
    `tpl_name` varchar(20) NOT NULL,
    `tpl_dir` varchar(255) NOT NULL,
    `tpl_active` tinyint(1) NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_languages`;
CREATE TABLE IF NOT EXISTS  `cnt_languages` (
    `id` tinyint(2) NOT NULL auto_increment,
    `language_name` varchar(20) NOT NULL,
    `language_file` varchar(5) NOT NULL,
    `language_active` tinyint(1) NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_users`;
CREATE TABLE IF NOT EXISTS `cnt_users` (
    `id` bigint(5) NOT NULL auto_increment,
    `user_nick` varchar(50) NOT NULL,
    `user_password` varchar(32) NOT NULL,
    `user_email` varchar(100) NOT NULL,
    `user_sex` tinyint(1) NOT NULL,
    `user_fullname` varchar(50) NOT NULL,
    `user_avatar` varchar(255) NULL,
    `user_birthday` varchar(10) NOT NULL,
    `user_info` varchar(255) NULL,
    `user_class` tinyint(2) NOT NULL,
    `user_regdate` int(10) NOT NULL,
    `user_level` tinyint(1) NOT NULL default '1',
    `user_ip` varchar(15) NOT NULL,
    `user_lastvisit` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_class`;
CREATE TABLE IF NOT EXISTS `cnt_class` (
    `id` tinyint(2) NOT NULL auto_increment,
    `class_name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_cats`;
CREATE TABLE IF NOT EXISTS `cnt_cats` (
    `id` tinyint(2) NOT NULL auto_increment,
    `cat_name` varchar(50) NOT NULL,
    `cat_name_ascii` varchar(50) NOT NULL,
    `cat_info` varchar(100) NOT NULL,
    `cat_type` tinyint(1) NOT NULL default '1',
    `cat_home` tinyint(1) NOT NULL default '0',
    `cat_order` tinyint(2) NOT NULL default '0',
    `cat_sub` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_posts`;
CREATE TABLE IF NOT EXISTS `cnt_posts` (
    `id` bigint(20) NOT NULL auto_increment,
    `post_name` varchar(100) NOT NULL,
    `post_name_ascii` varchar(100) NOT NULL,
    `post_quote` varchar(255) NOT NULL default '',
    `post_content` text,
    `post_image` varchar(255) NOT NULL default '',
    `post_file` varchar(255) NOT NULL default '',
    `post_comment` tinyint(1) NOT NULL default '1',
    `post_time` int(10) NOT NULL,
    `post_type` tinyint(1) NOT NULL default '1',
    `post_cat` tinyint(2) NULL,
    `post_user` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_datas`;
CREATE TABLE IF NOT EXISTS `cnt_datas` (
    `id` bigint(20) NOT NULL auto_increment,
    `data_name` varchar(100) NOT NULL default ' ',
    `data_info` varchar(255) NOT NULL default ' ',
    `data_url` varchar(255) NULL,
    `data_thumb` varchar(255) NULL,
    `data_time` int(10) NOT NULL,
    `data_type` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_messages`;
CREATE TABLE IF NOT EXISTS `cnt_messages` (
    `id` bigint(20) NOT NULL auto_increment,
    `message_title` varchar(255) NOT NULL,
    `message_content` text NOT NULL,
    `message_from` bigint(20) NULL,
    `message_to` bigint(20) NULL,
    `message_read` tinyint(1) NOT NULL default '0',
    `message_time` int(10) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_comments`;
CREATE TABLE IF NOT EXISTS  `cnt_comments` (
    `id` bigint(20) NOT NULL auto_increment,
    `comment_pid` bigint(20) NOT NULL,
    `comment_sid` bigint(20) NOT NULL default '0',
    `comment_content` text,
    `comment_user` bigint(20) NULL,
    `comment_time` int(10) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_supports`;
CREATE TABLE IF NOT EXISTS `cnt_supports` (
    `id` int(5) NOT NULL auto_increment,
    `support_name` varchar(50) NOT NULL,
    `support_mobile` varchar(15) NULL,
    `support_yahoo` varchar(50) NULL,
    `support_skype` varchar(50) NULL,
    `support_email` varchar(100) NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_ads`;
CREATE TABLE IF NOT EXISTS `cnt_ads` (
    `id` bigint(20) NOT NULL auto_increment,
    `ad_name` varchar(50) NOT NULL,
    `ad_image` varchar(255) NOT NULL,
    `ad_link` varchar(255) NOT NULL,
    `ad_type` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_contacts`;
CREATE TABLE IF NOT EXISTS `cnt_contacts` (
    `id` bigint(20) NOT NULL auto_increment,
    `contact_name` varchar(50) NOT NULL,
    `contact_email` varchar(255) NOT NULL,
    `contact_phone` varchar(15) NOT NULL,
    `contact_fax` varchar(15) NOT NULL,
    `contact_add` varchar(255) NOT NULL,
    `contact_title` varchar(255) NOT NULL,
    `contact_content` text,
    `contact_read` tinyint(1) NOT NULL default '0',
    `contact_time` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_products`;
CREATE TABLE IF NOT EXISTS `cnt_products` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `product_code` varchar(50) NOT NULL,
    `product_name` varchar(100) NOT NULL,
    `product_name_ascii` varchar(100) NOT NULL,
    `product_price` bigint(20) NOT NULL,
    `product_free` bigint(20) NOT NULL,
    `product_total` bigint(20) NOT NULL,
    `product_quality` varchar(20) NOT NULL,
    `product_warranty` tinyint(2) NOT NULL,
    `product_image` varchar(255) NOT NULL,
    `product_fullimg` varchar(255) NOT NULL,
    `product_descrip` text,
    `product_info` text,
    `product_view` bigint(20) NOT NULL default '0',
    `product_cat` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_bills`;
CREATE TABLE IF NOT EXISTS `cnt_bills` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `bill_name` varchar(50) NOT NULL,
    `bill_email` varchar(255) NOT NULL,
    `bill_phone` varchar(15) NOT NULL,
    `bill_fax` varchar(15) NOT NULL,
    `bill_add` varchar(255) NOT NULL,
    `bill_content` varchar(255) NOT NULL,
    `bill_pay` tinyint(1) NOT NULL default '0',
    `bill_user` bigint(20) NOT NULL default '0',
    `bill_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_slides`;
CREATE TABLE IF NOT EXISTS `cnt_slides` (
    `id` bigint(20) NOT NULL auto_increment,
    `slide_name` varchar(50) NOT NULL,
    `slide_img` varchar(255) NOT NULL,
    `slide_url` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_videos`;
CREATE TABLE IF NOT EXISTS `cnt_videos` (
    `id` bigint(20) NOT NULL auto_increment,
    `video_name` varchar(50) NOT NULL,
    `video_url` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_faqs`;
CREATE TABLE IF NOT EXISTS `cnt_faqs` (
    `id` tinyint(2) NOT NULL auto_increment,
    `faq_name` varchar(255) NOT NULL,
    `faq_content` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `cnt_polls`;
CREATE TABLE IF NOT EXISTS `cnt_polls` (
    `id` bigint(20) NOT NULL auto_increment,
    `poll_name` varchar(255) NOT NULL,
    `poll_active` tinyint(1) NOT NULL default '1',
    `poll_pid` bigint(20) NOT NULL default '0',
    `poll_votes` bigint(20) NOT NULL default '0',
    `poll_order` tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
