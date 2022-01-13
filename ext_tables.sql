CREATE TABLE tx_kfmobilede_domain_model_clients (
	name varchar(255) NOT NULL DEFAULT '',
	id varchar(255) NOT NULL DEFAULT '',
	username varchar(255) NOT NULL DEFAULT '',
	password varchar(255) NOT NULL DEFAULT '',
	apikey varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_kfmobilede_domain_model_vehicle (
	model_description varchar(255) NOT NULL DEFAULT '',
	class varchar(255) NOT NULL DEFAULT '',
	category varchar(255) NOT NULL DEFAULT '',
	make varchar(255) NOT NULL DEFAULT '',
	model varchar(255) NOT NULL DEFAULT '',
	price int(11) NOT NULL DEFAULT '0',
	damage_and_unrepaired smallint(1) unsigned NOT NULL DEFAULT '0',
	accident_damaged smallint(1) unsigned NOT NULL DEFAULT '0',
	roadworthy smallint(1) unsigned NOT NULL DEFAULT '0',
	price_type varchar(255) NOT NULL DEFAULT '',
	fuel varchar(255) NOT NULL DEFAULT '',
	gearbox varchar(255) NOT NULL DEFAULT '',
	color varchar(255) NOT NULL DEFAULT '',
	mileage varchar(255) NOT NULL DEFAULT '',
	seats varchar(255) NOT NULL DEFAULT '',
	doors varchar(255) NOT NULL DEFAULT '',
	power varchar(255) NOT NULL DEFAULT '',
	cubic_capacity varchar(255) NOT NULL DEFAULT '',
	emission_class varchar(255) NOT NULL DEFAULT '',
	images int(11) unsigned NOT NULL DEFAULT '0',
	image_data text NOT NULL DEFAULT '',
	description text,
	misc text NOT NULL DEFAULT '',
	consumer_price_amount varchar(255) NOT NULL DEFAULT '',
	dealer_price_amount varchar(255) NOT NULL DEFAULT '',
	first_registration datetime DEFAULT NULL,
	creation_date datetime DEFAULT NULL,
	modification_date datetime DEFAULT NULL,
	detail_page varchar(255) NOT NULL DEFAULT '',
	import_key varchar(255) NOT NULL DEFAULT '',
	import_client varchar(255) NOT NULL DEFAULT '',
	import smallint(1) unsigned NOT NULL DEFAULT '0',
	custom1 varchar(255) NOT NULL DEFAULT '',
	custom2 varchar(255) NOT NULL DEFAULT '',
	custom3 varchar(255) NOT NULL DEFAULT '',
	custom4 varchar(255) NOT NULL DEFAULT '',
	custom5 varchar(255) NOT NULL DEFAULT '',
	slug varchar(255) NOT NULL DEFAULT '',
	features int(11) unsigned NOT NULL DEFAULT '0',
	specifics int(11) unsigned NOT NULL DEFAULT '0',
	seller int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_kfmobilede_domain_model_features (
	name varchar(255) NOT NULL DEFAULT '',
	description varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_kfmobilede_domain_model_specifics (
	name varchar(255) NOT NULL DEFAULT '',
	description varchar(255) NOT NULL DEFAULT ''
);

CREATE TABLE tx_kfmobilede_domain_model_seller (
	company_name varchar(255) NOT NULL DEFAULT '',
	phone text NOT NULL DEFAULT '',
	street varchar(255) NOT NULL DEFAULT '',
	zipcode varchar(255) NOT NULL DEFAULT '',
	city varchar(255) NOT NULL DEFAULT '',
	country_code varchar(255) NOT NULL DEFAULT '',
	latitude varchar(255) NOT NULL DEFAULT '',
	longitude varchar(255) NOT NULL DEFAULT '',
	seller_image int(11) unsigned NOT NULL DEFAULT '0',
	seller_info text,
	url varchar(255) NOT NULL DEFAULT '',
	email varchar(255) NOT NULL DEFAULT '',
	commercial smallint(1) unsigned NOT NULL DEFAULT '0',
	import_key varchar(255) NOT NULL DEFAULT '',
	import smallint(1) unsigned NOT NULL DEFAULT '0'
);

CREATE TABLE tx_kfmobilede_vehicle_features_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

CREATE TABLE tx_kfmobilede_vehicle_specifics_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);
