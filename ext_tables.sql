#
# Table structure for table 'tx_kfmobilede_domain_model_clients'
#
CREATE TABLE tx_kfmobilede_domain_model_clients (

	name varchar(255) DEFAULT '' NOT NULL,
	id varchar(255) DEFAULT '' NOT NULL,
	username varchar(255) DEFAULT '' NOT NULL,
	password varchar(255) DEFAULT '' NOT NULL,
	apikey varchar(255) DEFAULT '' NOT NULL

);

#
# Table structure for table 'tx_kfmobilede_domain_model_vehicle'
#
CREATE TABLE tx_kfmobilede_domain_model_vehicle (

	model_description varchar(255) DEFAULT '' NOT NULL,
	class varchar(255) DEFAULT '' NOT NULL,
	category varchar(255) DEFAULT '' NOT NULL,
	make varchar(255) DEFAULT '' NOT NULL,
	model varchar(255) DEFAULT '' NOT NULL,
	price int(11) DEFAULT '0' NOT NULL,
	damage_and_unrepaired smallint(5) unsigned DEFAULT '0' NOT NULL,
	accident_damaged smallint(5) unsigned DEFAULT '0' NOT NULL,
	roadworthy smallint(5) unsigned DEFAULT '0' NOT NULL,
	price_type varchar(255) DEFAULT '' NOT NULL,
	fuel varchar(255) DEFAULT '' NOT NULL,
	gearbox varchar(255) DEFAULT '' NOT NULL,
	color varchar(255) DEFAULT '' NOT NULL,
	mileage varchar(255) DEFAULT '' NOT NULL,
	seats varchar(255) DEFAULT '' NOT NULL,
	doors varchar(255) DEFAULT '' NOT NULL,
	power varchar(255) DEFAULT '' NOT NULL,
	cubic_capacity varchar(255) DEFAULT '' NOT NULL,
	emission_class varchar(255) DEFAULT '' NOT NULL,
	images int(11) unsigned DEFAULT '0' NOT NULL,
	image_data text,
	description text,
	misc text,
	consumer_price_amount varchar(255) DEFAULT '' NOT NULL,
	dealer_price_amount varchar(255) DEFAULT '' NOT NULL,
	first_registration datetime DEFAULT NULL,
	creation_date datetime DEFAULT NULL,
	modification_date datetime DEFAULT NULL,
	detail_page varchar(255) DEFAULT '' NOT NULL,
	import_key varchar(255) DEFAULT '' NOT NULL,
	import_client varchar(255) DEFAULT '' NOT NULL,
	import smallint(5) unsigned DEFAULT '0' NOT NULL,
	custom1 varchar(255) DEFAULT '' NOT NULL,
	custom2 varchar(255) DEFAULT '' NOT NULL,
	custom3 varchar(255) DEFAULT '' NOT NULL,
	custom4 varchar(255) DEFAULT '' NOT NULL,
	custom5 varchar(255) DEFAULT '' NOT NULL,
	slug varchar(255) DEFAULT '' NOT NULL,
	features int(11) unsigned DEFAULT '0' NOT NULL,
	specifics int(11) unsigned DEFAULT '0' NOT NULL,
	seller int(11) unsigned DEFAULT '0'

);

#
# Table structure for table 'tx_kfmobilede_domain_model_features'
#
CREATE TABLE tx_kfmobilede_domain_model_features (

	name varchar(255) DEFAULT '' NOT NULL,
	description varchar(255) DEFAULT '' NOT NULL

);

#
# Table structure for table 'tx_kfmobilede_domain_model_specifics'
#
CREATE TABLE tx_kfmobilede_domain_model_specifics (

	name varchar(255) DEFAULT '' NOT NULL,
	description varchar(255) DEFAULT '' NOT NULL

);

#
# Table structure for table 'tx_kfmobilede_domain_model_seller'
#
CREATE TABLE tx_kfmobilede_domain_model_seller (

	company_name varchar(255) DEFAULT '' NOT NULL,
	phone text,
	street varchar(255) DEFAULT '' NOT NULL,
	zipcode varchar(255) DEFAULT '' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,
	country_code varchar(255) DEFAULT '' NOT NULL,
	latitude varchar(255) DEFAULT '' NOT NULL,
	longitude varchar(255) DEFAULT '' NOT NULL,
	seller_image int(11) unsigned NOT NULL default '0',
	seller_info text,
	url varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
	commercial smallint(5) unsigned DEFAULT '0' NOT NULL,
	import_key varchar(255) DEFAULT '' NOT NULL,
	import smallint(5) unsigned DEFAULT '0' NOT NULL

);

#
# Table structure for table 'tx_kfmobilede_vehicle_features_mm'
#
CREATE TABLE tx_kfmobilede_vehicle_features_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_kfmobilede_vehicle_specifics_mm'
#
CREATE TABLE tx_kfmobilede_vehicle_specifics_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);
