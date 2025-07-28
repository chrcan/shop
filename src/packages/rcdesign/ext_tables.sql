CREATE TABLE tt_content(
  row_items varchar(255) DEFAULT '' NOT NULL,
	rccard_group_item int(11) unsigned DEFAULT '0',
	rcaccordion_accordion_item int(11) unsigned DEFAULT '0',
	rccarousel_carousel_item int(11) unsigned DEFAULT '0',
);

-- --
-- -- Table structure for table 'rccard_group_item'
-- --
CREATE TABLE rccard_group_item (
	tt_content int(11) unsigned DEFAULT '0',
	header varchar(255) DEFAULT '' NOT NULL,
	image int(11) DEFAULT '0' NOT NULL,
	bodytext text,
	link varchar(1024) DEFAULT '' NOT NULL,
	link_title varchar(255) DEFAULT '' NOT NULL,
);

--
-- Table structure for table 'rcaccordion_accordion_item'
--
CREATE TABLE rcaccordion_accordion_item (
    tt_content int(11) unsigned DEFAULT '0',
    header varchar(255) DEFAULT '' NOT NULL,
    bodytext text,
    media int(11) unsigned DEFAULT '0',
    mediaorient varchar(60) DEFAULT 'left' NOT NULL,
    imagecols tinyint(4) unsigned DEFAULT '1' NOT NULL,
    image_zoom tinyint(3) unsigned DEFAULT '0' NOT NULL,
		columnwidth1 varchar(255) DEFAULT '' NOT NULL,
		columnwidth2 varchar(255) DEFAULT '' NOT NULL,
		position1 varchar(255) DEFAULT '' NOT NULL,
		position2 varchar(255) DEFAULT '' NOT NULL,
);

--
-- Table structure for table 'rccarousel_carousel_item'
--
CREATE TABLE rccarousel_carousel_item (
    tt_content int(11) unsigned DEFAULT '0',
    header varchar(255) DEFAULT '' NOT NULL,
    bodytext text,
    media int(11) unsigned DEFAULT '0',
);

--
-- Table structure for table 'rctab_tab_item'
--
CREATE TABLE rctab_tab_item (
    tt_content int(11) unsigned DEFAULT '0',
    header varchar(255) DEFAULT '' NOT NULL,
    bodytext text,
);
