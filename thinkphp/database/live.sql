
drop table if exists `live_team`;
create table if not exists `live_team`(
	`id` tinyint(1) unsigned not null auto_increment comment '球队ID',
	`name` varchar(50) not null default '' comment '球队名称',
	`image` varchar(50) not null default '' comment '球队图标',
	`type` tinyint(1) unsigned not null  default 0 comment '0东部 1西部',
	`create_time` int unsigned not null default 0 comment '创建时间',
	`update_time` int unsigned not null default 0 comment '更新时间',
	primary key (`id`)	
)engine=innodb default charset='utf8mb4' comment '球队表';



drop table if exists `live_game`;
create table if not exists `live_game`(
	`id` int unsigned not null auto_increment comment '直播ID',
	`a_id` tinyint(1) unsigned not null default 0 comment 'A球队',
	`b_id` tinyint(1) unsigned not null default 0 comment 'B球队',
	`a_score` int unsigned not null default 0 comment 'A队球分',
	`b_score` int unsigned not null default 0 comment 'B队球分',
	`status` tinyint(1) unsigned not null default 0 comment '直播状态',	
	`arrator` varchar(50) not null default '' comment '直播员',
	`image` varchar(50) not null default '' comment '球队图标',
	`start_time` int unsigned not null  default 0 comment '开始时间',
	`create_time` int unsigned not null default 0 comment '创建时间',
	`update_time` int unsigned not null default 0 comment '更新时间',
	primary key (`id`)	
)engine=innodb default charset='utf8mb4' comment '直播表';



drop table if exists `live_player`;
create table if not exists `live_player`(
	`id` int unsigned not null auto_increment comment '球员ID',
	`age` tinyint(1) unsigned not null default 0 comment '年龄',
	`position` tinyint(1) unsigned not null default 0 comment '球位',
	`status` tinyint(1) unsigned not null default 0 comment '球员状态',	
	`name` varchar(50) not null default '' comment '球员名称',
	`image` varchar(50) not null default '' comment '球员头像',
	`create_time` int unsigned not null default 0 comment '创建时间',
	`update_time` int unsigned not null default 0 comment '更新时间',
	primary key (`id`)	
)engine=innodb default charset='utf8mb4' comment '球员表';



drop table if exists `live_player`;
create table if not exists `live_player`(
	`id` int unsigned not null auto_increment comment '赛况ID',
	`game_id` int unsigned not null default 0 comment '直播ID',
	`team_id` tinyint(1) unsigned not null default 0 comment '球队ID',
	`status` tinyint(1) unsigned not null default 0 comment '赛况状态',
	`content` varchar(255) not null default '' comment '内容',	
	`type` tinyint(1) unsigned not null default 0 comment 'ok',
	`image` varchar(50) not null default '' comment '球员头像',
	`create_time` int unsigned not null default 0 comment '创建时间',
	primary key (`id`)	
)engine=innodb default charset='utf8mb4' comment '赛事赛况表';


drop table if exists `live_im`;
create table if not exists `live_im`(
	`id` int unsigned not null auto_increment comment '聊天ID',
	`user_id` int unsigned not null default 0 comment '用户id',
	`game_id` int unsigned not null default 0 comment '直播ID',
	`content` varchar(255) not null default '' comment '聊天内容',	
	`create_time` int unsigned not null default 0 comment '创建时间',
	primary key (`id`)	
)engine=innodb default charset='utf8mb4' comment '聊天表';