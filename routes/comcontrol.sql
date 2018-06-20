/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : comcontrol

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-06-20 10:12:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jd_admins
-- ----------------------------
DROP TABLE IF EXISTS `jd_admins`;
CREATE TABLE `jd_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `qq` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `headimg` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_login_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `login_count` int(11) DEFAULT '0',
  `role_id` int(11) DEFAULT '0' COMMENT '角色ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jd_admins
-- ----------------------------
INSERT INTO `jd_admins` VALUES ('1', 'admin', '06031306@163.com', '$2y$10$WL3WZA1bnePjP4xkdokG1uq0TLh0EbJPcNAJ.rO4ZUozOLNJgzfo6', 'uYq8BJVPBU2uHsEPEbszElQu5BUrrWGRdHo12iZ13azmyDfqkksPFoqBtYaj', '2018-05-29 17:14:46', '2018-06-20 01:07:18', '962755824', null, 'zhge d ', '2018-06-20 01:07:18', '127.0.0.1', '34', '9');
INSERT INTO `jd_admins` VALUES ('2', '测试', '962755824@qq.con', '$2y$10$iYrmRINdxagK0rRkzWl1QuKE6Xj1AHa2/ir5Ui9V8l/OSa6.wmble', '07GWU7n6gOtwUwfAcW9Hsk3AcFypYrV0wKlbvA4FR8rrTOMpVQZTQL8df0rd', '2018-06-14 07:04:20', '2018-06-14 07:09:39', '962755824', '15092312531', null, '2018-06-14 15:29:14', '127.0.0.1', '1', '9');
INSERT INTO `jd_admins` VALUES ('3', 'chenghao12', '282206316201@qq.com', '$2y$10$3brCs.hMFoRKMfhvZ6MO7OSDi7LmioJgCwg9aSdpF4f84l6cblyD.', 'bkafOME4gHHifeU3Hh5rCFMjwOx9rubTD0zERcxgH640qq38Yr48GCMKoCFp', '2018-06-14 07:06:50', '2018-06-14 07:29:38', '131313', '17774003567', null, '2018-06-14 15:29:44', '127.0.0.1', '1', '10');

-- ----------------------------
-- Table structure for jd_admin_feedbacks
-- ----------------------------
DROP TABLE IF EXISTS `jd_admin_feedbacks`;
CREATE TABLE `jd_admin_feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `title` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1-待处理 2-已查看 3-已忽略',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jd_admin_feedbacks
-- ----------------------------
INSERT INTO `jd_admin_feedbacks` VALUES ('2', '1', null, '<p>cedfdfd&nbsp;<br/></p>', '2', '2018-06-19 17:09:35', '2018-06-19 09:09:35');

-- ----------------------------
-- Table structure for jd_admin_menus
-- ----------------------------
DROP TABLE IF EXISTS `jd_admin_menus`;
CREATE TABLE `jd_admin_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1-显示 2-隐藏 3-不可删除',
  `node_id` int(11) DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jd_admin_menus
-- ----------------------------
INSERT INTO `jd_admin_menus` VALUES ('1', '管理员管理', '0', '1', '1', '12', 'admin.index', '2018-06-14 10:12:00', '2018-06-14 02:12:00');
INSERT INTO `jd_admin_menus` VALUES ('2', '管理员', '1', '1', '1', '12', 'admin.index', '2018-06-14 10:12:34', '2018-06-14 02:12:34');
INSERT INTO `jd_admin_menus` VALUES ('3', '节点管理', '1', '2', '1', '10', 'node.index', '2018-06-14 10:13:02', '2018-06-14 02:13:02');
INSERT INTO `jd_admin_menus` VALUES ('4', '后台菜单栏管理', '0', '2', '1', '11', 'menu.index', '2018-06-14 10:15:21', '2018-06-14 02:15:21');
INSERT INTO `jd_admin_menus` VALUES ('5', '公众号管理', '0', '4', '1', '5', null, '2018-06-14 16:39:45', '2018-06-14 08:39:45');
INSERT INTO `jd_admin_menus` VALUES ('6', '文章管理', '0', '5', '1', '17', null, '2018-06-14 16:40:30', '2018-06-14 08:40:30');
INSERT INTO `jd_admin_menus` VALUES ('7', '角色管理', '1', '3', '1', '5', 'role.index', '2018-06-14 02:13:35', '2018-06-14 02:13:35');
INSERT INTO `jd_admin_menus` VALUES ('8', '文章分类', '6', null, '1', '25', 'article_class.index', '2018-06-14 08:48:22', '2018-06-14 08:48:22');
INSERT INTO `jd_admin_menus` VALUES ('9', '文章列表', '6', '2', '1', '17', 'article.index', '2018-06-14 08:48:50', '2018-06-14 08:48:50');
INSERT INTO `jd_admin_menus` VALUES ('10', '菜单栏', '5', '1', '1', '15', 'wechat_menu.index', '2018-06-19 17:10:38', '2018-06-19 09:10:38');
INSERT INTO `jd_admin_menus` VALUES ('11', '投票管理', '0', '9', '1', '18', null, '2018-06-14 08:56:04', '2018-06-14 08:56:04');
INSERT INTO `jd_admin_menus` VALUES ('12', '投票活动', '11', '1', '1', '18', 'vote.index', '2018-06-14 16:56:46', '2018-06-14 08:56:46');
INSERT INTO `jd_admin_menus` VALUES ('13', '投票队伍', '11', '2', '1', '19', 'vote_team.index', '2018-06-14 08:57:44', '2018-06-14 08:57:44');
INSERT INTO `jd_admin_menus` VALUES ('14', '报名管理', '0', '11', '1', '24', null, '2018-06-14 09:07:25', '2018-06-14 09:07:25');
INSERT INTO `jd_admin_menus` VALUES ('15', '报名活动', '14', '1', '1', '24', 'register_activity.index', '2018-06-14 11:36:34', '2018-06-14 11:36:34');
INSERT INTO `jd_admin_menus` VALUES ('16', '报名用户', '14', null, '1', '26', 'register_user.index', '2018-06-14 19:38:10', '2018-06-14 11:38:10');
INSERT INTO `jd_admin_menus` VALUES ('17', '自动回复', '5', '2', '1', '16', 'auto_reply.index', '2018-06-15 09:04:33', '2018-06-15 09:04:33');
INSERT INTO `jd_admin_menus` VALUES ('18', '公众号账号', '5', '1', '1', '14', 'official_account.index', '2018-06-15 03:01:34', '2018-06-15 03:01:34');
INSERT INTO `jd_admin_menus` VALUES ('19', '后台意见反馈', '0', '99', '1', '13', 'admin_feedback.index', '2018-06-15 03:02:17', '2018-06-15 03:02:17');

-- ----------------------------
-- Table structure for jd_migrations
-- ----------------------------
DROP TABLE IF EXISTS `jd_migrations`;
CREATE TABLE `jd_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jd_migrations
-- ----------------------------

-- ----------------------------
-- Table structure for jd_nodes
-- ----------------------------
DROP TABLE IF EXISTS `jd_nodes`;
CREATE TABLE `jd_nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '所在模型',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jd_nodes
-- ----------------------------
INSERT INTO `jd_nodes` VALUES ('5', '管理员角色', 'Role', '2018-06-14 10:05:15', '2018-06-14 02:05:15');
INSERT INTO `jd_nodes` VALUES ('10', '节点资源', 'Node', '2018-06-14 10:05:51', '2018-06-14 02:05:51');
INSERT INTO `jd_nodes` VALUES ('11', '菜单栏', 'AdminMenu', '2018-06-14 02:07:00', '2018-06-14 02:07:00');
INSERT INTO `jd_nodes` VALUES ('12', '管理员', 'Admin', '2018-06-14 02:07:20', '2018-06-14 02:07:20');
INSERT INTO `jd_nodes` VALUES ('13', '后台反馈', 'AdminFeedback', '2018-06-14 02:07:42', '2018-06-14 02:07:42');
INSERT INTO `jd_nodes` VALUES ('14', '公众号信息', 'OfficialAccount', '2018-06-14 08:25:46', '2018-06-14 08:25:46');
INSERT INTO `jd_nodes` VALUES ('15', '微信菜单栏', 'WeChatMenu', '2018-06-14 08:26:24', '2018-06-14 08:26:24');
INSERT INTO `jd_nodes` VALUES ('16', '自动回复', 'AutoReply', '2018-06-14 08:27:36', '2018-06-14 08:27:36');
INSERT INTO `jd_nodes` VALUES ('17', '文章', 'Article', '2018-06-14 08:27:49', '2018-06-14 08:27:49');
INSERT INTO `jd_nodes` VALUES ('18', '投票', 'Vote', '2018-06-14 08:30:29', '2018-06-14 08:30:29');
INSERT INTO `jd_nodes` VALUES ('19', '投票队伍', 'VoteTeam', '2018-06-14 08:30:47', '2018-06-14 08:30:47');
INSERT INTO `jd_nodes` VALUES ('20', '抽奖活动', 'LotteryDraw', '2018-06-14 08:31:34', '2018-06-14 08:31:34');
INSERT INTO `jd_nodes` VALUES ('21', '奖品', 'Prize', '2018-06-14 08:32:03', '2018-06-14 08:32:03');
INSERT INTO `jd_nodes` VALUES ('22', '答题活动', 'AnswerActivity', '2018-06-14 08:35:29', '2018-06-14 08:35:29');
INSERT INTO `jd_nodes` VALUES ('23', '答题活动题目', 'Question', '2018-06-14 08:36:01', '2018-06-14 08:36:01');
INSERT INTO `jd_nodes` VALUES ('24', '报名活动', 'RegisterActivity', '2018-06-14 08:37:53', '2018-06-14 08:37:53');
INSERT INTO `jd_nodes` VALUES ('25', '文章分类', 'ArticleClass', '2018-06-14 08:43:12', '2018-06-14 08:43:12');
INSERT INTO `jd_nodes` VALUES ('26', '报名参加用户', 'RegisterActivityUser', '2018-06-14 11:37:48', '2018-06-14 11:37:48');

-- ----------------------------
-- Table structure for jd_official_accounts
-- ----------------------------
DROP TABLE IF EXISTS `jd_official_accounts`;
CREATE TABLE `jd_official_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appid` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appsecret` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1-正常，2-关闭',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jd_official_accounts
-- ----------------------------

-- ----------------------------
-- Table structure for jd_roles
-- ----------------------------
DROP TABLE IF EXISTS `jd_roles`;
CREATE TABLE `jd_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jd_roles
-- ----------------------------
INSERT INTO `jd_roles` VALUES ('9', '超级管理员', '2018-06-14 10:04:31', '2018-06-14 02:04:31');
INSERT INTO `jd_roles` VALUES ('10', '编辑', '2018-06-14 02:50:13', '2018-06-14 02:50:13');

-- ----------------------------
-- Table structure for jd_role_node
-- ----------------------------
DROP TABLE IF EXISTS `jd_role_node`;
CREATE TABLE `jd_role_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `node_id` int(11) DEFAULT NULL,
  `create` tinyint(1) DEFAULT NULL,
  `update` tinyint(1) DEFAULT NULL,
  `view` tinyint(1) DEFAULT NULL,
  `delete` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jd_role_node
-- ----------------------------
INSERT INTO `jd_role_node` VALUES ('14', '9', '10', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('15', '9', '5', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('16', '9', '11', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('17', '9', '12', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('18', '9', '13', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('19', '9', '14', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('20', '9', '15', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('21', '9', '16', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('22', '9', '17', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('23', '9', '18', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('24', '9', '19', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('25', '9', '20', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('26', '9', '21', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('27', '9', '22', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('28', '9', '23', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('29', '9', '24', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('30', '9', '25', '1', '1', '1', '1');
INSERT INTO `jd_role_node` VALUES ('31', '9', '26', '1', '1', '1', '1');
