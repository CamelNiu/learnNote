CREATE TABLE IF NOT EXISTS `big_data_test`(
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `keys` char(32) not null DEFAULT "",
    primary key (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='交易统计结果表主表';
