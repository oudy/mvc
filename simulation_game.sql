/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : simulation_game

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2012-04-13 08:53:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sg_admin`
-- ----------------------------
DROP TABLE IF EXISTS `sg_admin`;
CREATE TABLE `sg_admin` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL DEFAULT '',
  `gonghao` varchar(30) NOT NULL DEFAULT '',
  `truename` varchar(30) NOT NULL DEFAULT '',
  `telephone` varchar(30) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `salt` int(11) NOT NULL COMMENT '六位随机数 MD5加密所用',
  `dateline` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '状态',
  `roleid` int(11) NOT NULL DEFAULT '0',
  `comment` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of sg_admin
-- ----------------------------
INSERT INTO `sg_admin` VALUES ('1', 'admin', '4504e382a14acebf77cad0bbebfd77d2', 'a138s@163.com', '419', '欧小明', '0755-8888888', '15012725038', '158672', '1331617508', '0', '1', '');

-- ----------------------------
-- Table structure for `sg_admin_auth`
-- ----------------------------
DROP TABLE IF EXISTS `sg_admin_auth`;
CREATE TABLE `sg_admin_auth` (
  `auid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '单个权限名称',
  `authid` varchar(30) NOT NULL DEFAULT '' COMMENT '权限标识，英文下划线',
  `cid` int(11) NOT NULL COMMENT '所属权限分类ID',
  PRIMARY KEY (`auid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员权限标识表';

-- ----------------------------
-- Records of sg_admin_auth
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_admin_auth_class`
-- ----------------------------
DROP TABLE IF EXISTS `sg_admin_auth_class`;
CREATE TABLE `sg_admin_auth_class` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `upid` int(11) NOT NULL COMMENT '父级ID',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员权限分类表';

-- ----------------------------
-- Records of sg_admin_auth_class
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_admin_role`
-- ----------------------------
DROP TABLE IF EXISTS `sg_admin_role`;
CREATE TABLE `sg_admin_role` (
  `arid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `order` int(11) NOT NULL COMMENT '显示排序',
  `authid` varchar(1000) NOT NULL DEFAULT '' COMMENT '受权id序号，多个用逗号分开',
  PRIMARY KEY (`arid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='管理员角色表';

-- ----------------------------
-- Records of sg_admin_role
-- ----------------------------
INSERT INTO `sg_admin_role` VALUES ('1', '超级管理员', '0', '');
INSERT INTO `sg_admin_role` VALUES ('2', '管理员', '0', '');
INSERT INTO `sg_admin_role` VALUES ('3', '客服主管', '0', '');
INSERT INTO `sg_admin_role` VALUES ('4', '财务主管', '0', '');
INSERT INTO `sg_admin_role` VALUES ('5', '客服', '0', '');
INSERT INTO `sg_admin_role` VALUES ('6', '信息部管理员', '0', '');
INSERT INTO `sg_admin_role` VALUES ('7', '信息部操作员', '0', '');
INSERT INTO `sg_admin_role` VALUES ('8', '财务操盘', '0', '');
INSERT INTO `sg_admin_role` VALUES ('9', '财务复审', '0', '');
INSERT INTO `sg_admin_role` VALUES ('10', '财务审核', '0', '');
INSERT INTO `sg_admin_role` VALUES ('11', '财务收款', '0', '');
INSERT INTO `sg_admin_role` VALUES ('12', '后台用户初始化', '0', '');
INSERT INTO `sg_admin_role` VALUES ('13', '数据部管理员', '0', '');
INSERT INTO `sg_admin_role` VALUES ('14', '数据部操作员', '0', '');
INSERT INTO `sg_admin_role` VALUES ('15', '客服+信息主管', '0', '');
INSERT INTO `sg_admin_role` VALUES ('16', '营销管理', '0', '');

-- ----------------------------
-- Table structure for `sg_comment`
-- ----------------------------
DROP TABLE IF EXISTS `sg_comment`;
CREATE TABLE `sg_comment` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `essence` varchar(1000) NOT NULL DEFAULT '' COMMENT '摘要',
  `content` varchar(1000) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '评论状态 0 未审核 -1 锁定 1 通过',
  `ip` varchar(20) NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论表';

-- ----------------------------
-- Records of sg_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_config`
-- ----------------------------
DROP TABLE IF EXISTS `sg_config`;
CREATE TABLE `sg_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mintradeshou` varchar(15) NOT NULL DEFAULT '' COMMENT '最低交易手数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统配置表';

-- ----------------------------
-- Records of sg_config
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_contest_schedule`
-- ----------------------------
DROP TABLE IF EXISTS `sg_contest_schedule`;
CREATE TABLE `sg_contest_schedule` (
  `csid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `starttime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,
  `year` varchar(4) NOT NULL DEFAULT '',
  PRIMARY KEY (`csid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='赛程表';

-- ----------------------------
-- Records of sg_contest_schedule
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_invite_friend`
-- ----------------------------
DROP TABLE IF EXISTS `sg_invite_friend`;
CREATE TABLE `sg_invite_friend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upuid` int(11) NOT NULL COMMENT '父级UID',
  `uid` int(11) NOT NULL,
  `srctype` tinyint(4) NOT NULL DEFAULT '1' COMMENT '来源 1 互联网 2 手机',
  `status` tinyint(4) NOT NULL COMMENT '默认  0 为无效  1 有效',
  `level` tinyint(4) NOT NULL COMMENT '第几层关系链',
  `parent_struct` text NOT NULL COMMENT '父级层结构 如 abc100/test100/  续尾必须有"/"',
  `dateline` int(11) NOT NULL COMMENT '生成时间',
  `effective_dateline` int(11) NOT NULL COMMENT '户用交易一笔 成了有效推广时间',
  `csid` int(11) NOT NULL COMMENT '对应某个赛程ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='推广好友关系表';

-- ----------------------------
-- Records of sg_invite_friend
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_invite_friend_record`
-- ----------------------------
DROP TABLE IF EXISTS `sg_invite_friend_record`;
CREATE TABLE `sg_invite_friend_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `truename` varchar(50) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `sid` int(11) NOT NULL COMMENT '对应手机短信模板表的sid',
  `fromuid` int(11) NOT NULL COMMENT '谁发送的邀请',
  `dateline` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='推广好友记录表';

-- ----------------------------
-- Records of sg_invite_friend_record
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_log`
-- ----------------------------
DROP TABLE IF EXISTS `sg_log`;
CREATE TABLE `sg_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户编号',
  `username` varchar(64) NOT NULL COMMENT '用户名',
  `appname` varchar(64) NOT NULL COMMENT '应用程序名',
  `action` varchar(64) NOT NULL,
  `event` varchar(128) NOT NULL COMMENT '件事',
  `result` tinyint(1) NOT NULL COMMENT '操作结果',
  `dateline` int(11) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户操作日志表';

-- ----------------------------
-- Records of sg_log
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_message`
-- ----------------------------
DROP TABLE IF EXISTS `sg_message`;
CREATE TABLE `sg_message` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `touid` int(11) NOT NULL COMMENT '消息发给谁',
  `tousername` varchar(50) NOT NULL,
  `dateline` int(11) NOT NULL,
  `message` varchar(1000) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '态状 0 未读 1 已阅读',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息表';

-- ----------------------------
-- Records of sg_message
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_notice`
-- ----------------------------
DROP TABLE IF EXISTS `sg_notice`;
CREATE TABLE `sg_notice` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(1000) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL,
  `sender` varchar(50) NOT NULL DEFAULT '' COMMENT '发布人',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='公告表';

-- ----------------------------
-- Records of sg_notice
-- ----------------------------
INSERT INTO `sg_notice` VALUES ('21', '<p>test 10 25 测试</p>', 'sadas', '1331087120', '419');
INSERT INTO `sg_notice` VALUES ('20', '<p>测试内容</p>', '测试 123456', '2012', '419');
INSERT INTO `sg_notice` VALUES ('23', '<p>测试 1222222222222222</p>', 'sadas', '1331694075', '419');

-- ----------------------------
-- Table structure for `sg_reward_class`
-- ----------------------------
DROP TABLE IF EXISTS `sg_reward_class`;
CREATE TABLE `sg_reward_class` (
  `rcid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`rcid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='奖品分类表';

-- ----------------------------
-- Records of sg_reward_class
-- ----------------------------
INSERT INTO `sg_reward_class` VALUES ('1', '团队奖');
INSERT INTO `sg_reward_class` VALUES ('2', '团员奖');
INSERT INTO `sg_reward_class` VALUES ('3', '伯乐奖');
INSERT INTO `sg_reward_class` VALUES ('4', '推广奖');
INSERT INTO `sg_reward_class` VALUES ('5', '个人奖');

-- ----------------------------
-- Table structure for `sg_reward_history`
-- ----------------------------
DROP TABLE IF EXISTS `sg_reward_history`;
CREATE TABLE `sg_reward_history` (
  `rhid` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(4) NOT NULL COMMENT '年份',
  `csid` int(11) NOT NULL COMMENT '对应赛程ID',
  `rsid` int(11) NOT NULL COMMENT '获奖类型',
  `username` varchar(50) NOT NULL DEFAULT '',
  `truename` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `trades` varchar(20) NOT NULL COMMENT '交易手数',
  `reward` varchar(30) NOT NULL COMMENT '奖品名',
  `profit` varchar(30) NOT NULL COMMENT '获利',
  `profitpercent` varchar(30) NOT NULL COMMENT '盈利率',
  PRIMARY KEY (`rhid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='获奖历史记录表';

-- ----------------------------
-- Records of sg_reward_history
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_reward_member`
-- ----------------------------
DROP TABLE IF EXISTS `sg_reward_member`;
CREATE TABLE `sg_reward_member` (
  `rmid` int(11) NOT NULL AUTO_INCREMENT,
  `csid` int(11) NOT NULL COMMENT '对应赛程ID',
  `uid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(50) NOT NULL,
  `rcid` tinyint(4) NOT NULL COMMENT '获奖类型 ID',
  `dateline` int(11) NOT NULL,
  `checkbodycart` tinyint(4) NOT NULL COMMENT '0 默认 1通过认证',
  `status` tinyint(4) NOT NULL COMMENT '0 默认 1 通过审核 -1 审核不通过',
  PRIMARY KEY (`rmid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='获奖成员表';

-- ----------------------------
-- Records of sg_reward_member
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_reward_setting`
-- ----------------------------
DROP TABLE IF EXISTS `sg_reward_setting`;
CREATE TABLE `sg_reward_setting` (
  `rsid` int(11) NOT NULL,
  `csid` int(11) NOT NULL COMMENT '对应赛程的ID',
  `person` varchar(1000) NOT NULL DEFAULT '' COMMENT '个人奖',
  `team` varchar(1000) NOT NULL DEFAULT '' COMMENT '团队奖',
  `invite` varchar(1000) NOT NULL DEFAULT '' COMMENT '邀请奖',
  `updown_proportion` varchar(20) NOT NULL DEFAULT '' COMMENT '上下抽成',
  `comment` varchar(1000) NOT NULL DEFAULT '' COMMENT '备注',
  `dateline` int(11) NOT NULL,
  PRIMARY KEY (`rsid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='奖品设置表';

-- ----------------------------
-- Records of sg_reward_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_session`
-- ----------------------------
DROP TABLE IF EXISTS `sg_session`;
CREATE TABLE `sg_session` (
  `id` char(32) CHARACTER SET utf8 NOT NULL,
  `modified` int(10) NOT NULL,
  `lifetime` int(10) NOT NULL,
  `data` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='SEESION保存表(跨服务器)';

-- ----------------------------
-- Records of sg_session
-- ----------------------------
INSERT INTO `sg_session` VALUES ('11979e5e3ac92a844328cc4cc17cfae8', '1333072276', '1440', '');
INSERT INTO `sg_session` VALUES ('d0bfac4b2023598f222c6fe7808f314d', '1333072276', '1440', '');
INSERT INTO `sg_session` VALUES ('7cftdosq2iveb9nvhoap09ctm6', '1332998664', '1440', '');
INSERT INTO `sg_session` VALUES ('966c3dffcf67ab1af7791b88f13fe5ef', '1331696059', '1440', '');
INSERT INTO `sg_session` VALUES ('a3e85f786dc5d1ca55e417d08aeb0e20', '1331717574', '1440', '');
INSERT INTO `sg_session` VALUES ('899687c91d3fad948016c3f961a4ef17', '1331772716', '1440', '');
INSERT INTO `sg_session` VALUES ('9ulggb756dqhs34tv1gi51mm37', '1332998564', '1440', '');
INSERT INTO `sg_session` VALUES ('f847932d609483f69771e661697333de', '1333083614', '1440', '');
INSERT INTO `sg_session` VALUES ('149b6ba94c9a5a5c9daf8e97779d142e', '1333083614', '1440', '');
INSERT INTO `sg_session` VALUES ('20d3hgtvvlai7l9126ojc2h983', '1333092044', '1440', 'adminSession|a:2:{s:6:\"roleid\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";}');
INSERT INTO `sg_session` VALUES ('6fg002c6ro7urfvap6sm44i3b6', '1333097409', '1440', '');
INSERT INTO `sg_session` VALUES ('gtnk8ghgfr8bqhdpea6q6ok1g4', '1333098725', '1440', '');
INSERT INTO `sg_session` VALUES ('qnrjtiu1edp73tt8n7qjhusru3', '1333098725', '1440', '');
INSERT INTO `sg_session` VALUES ('4vllmr4k8ctc588rcivm25rot1', '1333102509', '1440', '');
INSERT INTO `sg_session` VALUES ('ugdiesdkphld6nrvtqhrf6i1d5', '1333102509', '1440', '');
INSERT INTO `sg_session` VALUES ('n27libr6vhr5mv0j5pbbe4jjv0', '1333106027', '1440', '');
INSERT INTO `sg_session` VALUES ('mnj91sgn1jllabg3lkctjeepn1', '1333106027', '1440', '');
INSERT INTO `sg_session` VALUES ('8e1fniobsprmh1kepq81r7lui5', '1333108702', '1440', '');
INSERT INTO `sg_session` VALUES ('d5fhqdkqoe7lv7b9i1o6bgnls1', '1333108702', '1440', '');
INSERT INTO `sg_session` VALUES ('1t6eioidi5m186sa5i2oulmiq5', '1333116418', '1440', '');
INSERT INTO `sg_session` VALUES ('i6u6p172qkjtes2f2nmd5hs7v0', '1333116418', '1440', '');
INSERT INTO `sg_session` VALUES ('hh18rllde5a9eu5kutk58n7qq4', '1333121555', '1440', '');
INSERT INTO `sg_session` VALUES ('pkld6cmiu3r7m9psv9kf2schq4', '1333121555', '1440', '');
INSERT INTO `sg_session` VALUES ('bmnhkfl3v2it2fh1c1v2neoed1', '1333124125', '1440', '');
INSERT INTO `sg_session` VALUES ('bq6vepm0o759lf3mad8h354dd0', '1333124125', '1440', '');
INSERT INTO `sg_session` VALUES ('53rbprtkk6jmmp0bm9qbtt4785', '1333332253', '1440', '');
INSERT INTO `sg_session` VALUES ('b1j82u61ifqan3qb3idftf9js6', '1333332254', '1440', '');
INSERT INTO `sg_session` VALUES ('4p23gt01f110av5b2gfd1k0d30', '1333347666', '1440', '');
INSERT INTO `sg_session` VALUES ('5rc0eaur1gc66fdvr883nln583', '1333347666', '1440', '');
INSERT INTO `sg_session` VALUES ('tbup99fnggq99j9f5lbj6orbv5', '1333351279', '1440', '');
INSERT INTO `sg_session` VALUES ('o6ob91ngip9i885mtotl420uf1', '1333351279', '1440', '');
INSERT INTO `sg_session` VALUES ('biv4kk5n1fstch8klv0i4e7j45', '1334107229', '1440', '');

-- ----------------------------
-- Table structure for `sg_short_message`
-- ----------------------------
DROP TABLE IF EXISTS `sg_short_message`;
CREATE TABLE `sg_short_message` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(1000) NOT NULL DEFAULT '',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '短信类型 1 为个人 2 为团队',
  `dateline` int(11) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='手机短信模板表';

-- ----------------------------
-- Records of sg_short_message
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_team`
-- ----------------------------
DROP TABLE IF EXISTS `sg_team`;
CREATE TABLE `sg_team` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `membernum` tinyint(4) NOT NULL DEFAULT '0' COMMENT '成员数量  最大为4个',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 无效团 1 有效团',
  `dateline` int(11) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='团队信息表';

-- ----------------------------
-- Records of sg_team
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_team_count`
-- ----------------------------
DROP TABLE IF EXISTS `sg_team_count`;
CREATE TABLE `sg_team_count` (
  `tcid` int(11) NOT NULL AUTO_INCREMENT,
  `csid` int(11) NOT NULL COMMENT '对应赛程ID',
  `tid` int(11) NOT NULL COMMENT '对应团队ID',
  `tradeshou` varchar(30) NOT NULL DEFAULT '' COMMENT '交易手数',
  `tradebi` varchar(30) NOT NULL DEFAULT '' COMMENT '交易笔数',
  `profitpercent` varchar(20) NOT NULL DEFAULT '' COMMENT '盈利率',
  PRIMARY KEY (`tcid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='团队赛程统计表';

-- ----------------------------
-- Records of sg_team_count
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_team_invite`
-- ----------------------------
DROP TABLE IF EXISTS `sg_team_invite`;
CREATE TABLE `sg_team_invite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upuid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0 默认 1 接受 -1 拒绝 -2 踢出',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='团队邀请下线入团';

-- ----------------------------
-- Records of sg_team_invite
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_team_member`
-- ----------------------------
DROP TABLE IF EXISTS `sg_team_member`;
CREATE TABLE `sg_team_member` (
  `mid` int(11) NOT NULL,
  `tid` int(11) NOT NULL COMMENT '所属某个团队的ID ',
  `uid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1 团员 2 团队',
  `dateline` int(11) NOT NULL,
  `csid` int(11) NOT NULL COMMENT '对应赛程ID',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='团队成员表';

-- ----------------------------
-- Records of sg_team_member
-- ----------------------------

-- ----------------------------
-- Table structure for `sg_user`
-- ----------------------------
DROP TABLE IF EXISTS `sg_user`;
CREATE TABLE `sg_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `sg_username` varchar(50) NOT NULL DEFAULT '' COMMENT '模拟用户 用户名',
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `salt` char(6) NOT NULL DEFAULT '' COMMENT '随机数字 作为辅助密码MD5所用',
  `sex` tinyint(4) NOT NULL COMMENT '默认 0 保密 1 男 2 女',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `truename` varchar(50) NOT NULL DEFAULT '',
  `idcardtype` tinyint(4) NOT NULL COMMENT '证件类型',
  `idcardcode` varchar(50) NOT NULL DEFAULT '' COMMENT '证件号码',
  `email` varchar(60) NOT NULL DEFAULT '',
  `qq` int(11) NOT NULL DEFAULT '0',
  `msn` varchar(60) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `birthday` date NOT NULL,
  `feel` varchar(1000) NOT NULL DEFAULT '' COMMENT '获奖心得',
  `idcard_pic` varchar(60) NOT NULL DEFAULT '' COMMENT '证件图片',
  `person_pic` varchar(60) NOT NULL DEFAULT '' COMMENT '个人照片',
  `trade_pic` varchar(60) NOT NULL DEFAULT '' COMMENT '交易图片',
  `regip` char(15) NOT NULL DEFAULT '' COMMENT '注册IP',
  `regdate` int(11) NOT NULL,
  `lastloginip` char(20) NOT NULL DEFAULT '',
  `lastlogintime` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '用户状态，被锁等 具体值待定',
  `openid` varchar(50) NOT NULL DEFAULT '' COMMENT 'QQ帐号登陆唯一标识',
  `teams` int(11) NOT NULL COMMENT '团队数',
  `invites` int(11) NOT NULL COMMENT '推广数',
  `effectinvites` int(11) NOT NULL COMMENT '有效推广数',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=10004 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of sg_user
-- ----------------------------
INSERT INTO `sg_user` VALUES ('1', '', '张三', '', '', '0', '15012725036', '', '0', '', '1533434@qq.com', '0', '', '', '0000-00-00', '', '', '', '', '', '0', '', '0', '0', '', '0', '0', '0');
INSERT INTO `sg_user` VALUES ('2', '', '李四', '', '', '1', '15012725031', '', '0', '', 'awedf@163.com', '0', '', '', '0000-00-00', '', '', '', '', '', '0', '', '0', '0', '', '0', '0', '0');
INSERT INTO `sg_user` VALUES ('3', '', '龙五', '', '', '2', '13612541253', '', '0', '', 'a138s@hotmail.com', '0', '', '', '0000-00-00', '', '', '', '', '', '0', '', '0', '0', '', '0', '0', '0');

-- ----------------------------
-- Table structure for `sg_useryouhui`
-- ----------------------------
DROP TABLE IF EXISTS `sg_useryouhui`;
CREATE TABLE `sg_useryouhui` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `sg_username` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `salt` char(6) NOT NULL DEFAULT '' COMMENT '随机数字 作为辅助密码MD5所用',
  `sex` tinyint(4) NOT NULL COMMENT '默认 0 保密 1 男 2 女',
  `mobile_area` varchar(10) NOT NULL DEFAULT '',
  `mobile_no` varchar(20) NOT NULL DEFAULT '',
  `other_contact` varchar(100) NOT NULL DEFAULT '',
  `truename` varchar(50) NOT NULL DEFAULT '',
  `idcardtype` tinyint(4) NOT NULL COMMENT '证件类型',
  `idcardcode` varchar(50) NOT NULL DEFAULT '' COMMENT '证件号码',
  `email` varchar(60) NOT NULL DEFAULT '',
  `qq` int(11) NOT NULL DEFAULT '0',
  `skype` varchar(60) NOT NULL DEFAULT '',
  `msn` varchar(60) NOT NULL DEFAULT '',
  `countryid` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `sel_bankname` varchar(60) NOT NULL DEFAULT '' COMMENT '取款银行名称',
  `bankaddr` varchar(100) NOT NULL COMMENT '所属支行名称',
  `bankswift` varchar(100) NOT NULL DEFAULT '' COMMENT '国际汇款代码',
  `bankno` varchar(255) NOT NULL DEFAULT '' COMMENT '取款银行账号',
  `amount` varchar(100) NOT NULL DEFAULT '' COMMENT '开户金额',
  `question` varchar(60) NOT NULL DEFAULT '' COMMENT '问题',
  `question_other` varchar(60) NOT NULL DEFAULT '',
  `answer` varchar(60) NOT NULL COMMENT '答案',
  `own_expense` varchar(15) NOT NULL DEFAULT '' COMMENT '平仓交易编码',
  `notice` varchar(15) NOT NULL DEFAULT '' COMMENT '通知服务',
  `week_comment` varchar(15) NOT NULL COMMENT '每周专家评论',
  `birthday` date NOT NULL,
  `feel` varchar(1000) NOT NULL DEFAULT '' COMMENT '获奖心得',
  `idcard_pic` varchar(60) NOT NULL DEFAULT '' COMMENT '证件图片',
  `person_pic` varchar(60) NOT NULL DEFAULT '' COMMENT '个人照片',
  `trade_pic` varchar(60) NOT NULL DEFAULT '' COMMENT '交易图片',
  `regip` char(15) NOT NULL DEFAULT '' COMMENT '注册IP',
  `regdate` int(11) NOT NULL,
  `lastloginip` char(20) NOT NULL DEFAULT '',
  `lastlogintime` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '用户状态，被锁等 具体值待定',
  `openid` varchar(50) NOT NULL DEFAULT '' COMMENT 'QQ帐号登陆唯一标识',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=10004 DEFAULT CHARSET=utf8 COMMENT='优惠用户表';

-- ----------------------------
-- Records of sg_useryouhui
-- ----------------------------
INSERT INTO `sg_useryouhui` VALUES ('1', '', '张三', '', '', '0', '', '15012725036', '', '', '0', '', '1533434@qq.com', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '0', '', '0', '0', '');
INSERT INTO `sg_useryouhui` VALUES ('2', '', '李四', '', '', '0', '', '15012725031', '', '', '0', '', 'awedf@163.com', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '0', '', '0', '0', '');
INSERT INTO `sg_useryouhui` VALUES ('3', '', '龙五', '', '', '0', '', '13612541253', '', '', '0', '', 'a138s@hotmail.com', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', '0', '', '0', '0', '');

-- ----------------------------
-- Table structure for `sg_user_count`
-- ----------------------------
DROP TABLE IF EXISTS `sg_user_count`;
CREATE TABLE `sg_user_count` (
  `ucid` int(11) NOT NULL AUTO_INCREMENT,
  `csid` int(11) NOT NULL COMMENT '对应赛程ID',
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT '',
  `tradeshou` varchar(30) NOT NULL DEFAULT '' COMMENT '交易手数',
  `tradebi` varchar(30) NOT NULL DEFAULT '' COMMENT '交易笔数',
  PRIMARY KEY (`ucid`)
) ENGINE=MyISAM AUTO_INCREMENT=10004 DEFAULT CHARSET=utf8 COMMENT='用户赛程统计表';

-- ----------------------------
-- Records of sg_user_count
-- ----------------------------
INSERT INTO `sg_user_count` VALUES ('1', '0', '1', 'sadsad', '', '');
INSERT INTO `sg_user_count` VALUES ('2', '0', '2', '李四', '', '');
INSERT INTO `sg_user_count` VALUES ('3', '0', '3', '龙五', '', '');
