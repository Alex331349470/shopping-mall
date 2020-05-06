/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : 127.0.0.1:3306
 Source Schema         : shopmall

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 02/05/2020 15:48:58
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `permission` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES (1, 2, 1, '系统环境', 'fa-bar-chart', '/', NULL, NULL, '2020-04-25 08:56:58');
INSERT INTO `admin_menu` VALUES (2, 0, 2, '系统设置', 'fa-tasks', NULL, NULL, NULL, '2020-04-11 23:26:56');
INSERT INTO `admin_menu` VALUES (3, 2, 3, '后台用户管理', 'fa-users', 'auth/users', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (4, 2, 4, '后台角色管理', 'fa-user', 'auth/roles', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (5, 2, 5, '后台权限管理', 'fa-ban', 'auth/permissions', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (6, 2, 6, '后台菜单管理', 'fa-bars', 'auth/menu', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (7, 2, 7, '操作日志', 'fa-history', 'auth/logs', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (8, 0, 0, '会员管理', 'fa-user-md', NULL, NULL, '2020-04-11 23:32:03', '2020-04-11 23:33:17');
INSERT INTO `admin_menu` VALUES (9, 8, 0, '会员列表', 'fa-list', 'wx/users', NULL, '2020-04-11 23:35:52', '2020-04-11 23:35:52');
INSERT INTO `admin_menu` VALUES (11, 8, 0, '绩效管理', 'fa-archive', 'wx/commission', NULL, '2020-04-11 23:50:33', '2020-04-11 23:50:33');
INSERT INTO `admin_menu` VALUES (12, 0, 0, '订单管理', 'fa-stack-overflow', NULL, NULL, '2020-04-11 23:52:44', '2020-04-11 23:52:44');
INSERT INTO `admin_menu` VALUES (13, 12, 0, '订单列表', 'fa-list', 'wx/orders', NULL, '2020-04-11 23:53:19', '2020-04-11 23:53:19');
INSERT INTO `admin_menu` VALUES (14, 0, 0, '商品管理', 'fa-product-hunt', NULL, NULL, '2020-04-11 23:54:49', '2020-04-11 23:54:49');
INSERT INTO `admin_menu` VALUES (15, 14, 0, '商品列表', 'fa-list', 'wx/goods', NULL, '2020-04-11 23:55:25', '2020-04-11 23:55:25');
INSERT INTO `admin_menu` VALUES (16, 0, 0, '广告管理', 'fa-tripadvisor', NULL, NULL, '2020-04-11 23:56:19', '2020-04-11 23:56:19');
INSERT INTO `admin_menu` VALUES (17, 16, 0, '广告列表', 'fa-list', 'wx/advertises', NULL, '2020-04-11 23:56:47', '2020-04-13 13:57:55');
INSERT INTO `admin_menu` VALUES (18, 0, 0, '评论管理', 'fa-commenting', NULL, NULL, '2020-04-11 23:57:35', '2020-04-11 23:57:35');
INSERT INTO `admin_menu` VALUES (19, 18, 0, '评论列表', 'fa-list', 'wx/reply', NULL, '2020-04-11 23:58:07', '2020-04-11 23:58:07');
INSERT INTO `admin_menu` VALUES (20, 14, 0, '规格设置', 'fa-cogs', 'specifications', NULL, '2020-04-13 13:25:16', '2020-04-13 13:25:16');
INSERT INTO `admin_menu` VALUES (21, 14, 0, '分类管理', 'fa-object-ungroup', 'wx/categories', NULL, '2020-04-13 13:26:41', '2020-04-15 06:39:41');

-- ----------------------------
-- Table structure for admin_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `admin_operation_log`;
CREATE TABLE `admin_operation_log`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `admin_operation_log_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 113 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_operation_log
-- ----------------------------
INSERT INTO `admin_operation_log` VALUES (1, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-05-02 14:19:25', '2020-05-02 14:19:25');
INSERT INTO `admin_operation_log` VALUES (2, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-05-02 14:22:53', '2020-05-02 14:22:53');
INSERT INTO `admin_operation_log` VALUES (3, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:23:05', '2020-05-02 14:23:05');
INSERT INTO `admin_operation_log` VALUES (4, 1, 'admin/wx/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:23:11', '2020-05-02 14:23:11');
INSERT INTO `admin_operation_log` VALUES (5, 1, 'admin/auth/users', 'GET', '127.0.0.1', '[]', '2020-05-02 14:23:14', '2020-05-02 14:23:14');
INSERT INTO `admin_operation_log` VALUES (6, 1, 'admin/auth/users', 'GET', '127.0.0.1', '[]', '2020-05-02 14:24:09', '2020-05-02 14:24:09');
INSERT INTO `admin_operation_log` VALUES (7, 1, 'admin/wx/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:24:16', '2020-05-02 14:24:16');
INSERT INTO `admin_operation_log` VALUES (8, 1, 'admin/auth/users', 'GET', '127.0.0.1', '[]', '2020-05-02 14:24:20', '2020-05-02 14:24:20');
INSERT INTO `admin_operation_log` VALUES (9, 1, 'admin/wx/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:25:14', '2020-05-02 14:25:14');
INSERT INTO `admin_operation_log` VALUES (10, 1, 'admin/wx/levels', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:25:27', '2020-05-02 14:25:27');
INSERT INTO `admin_operation_log` VALUES (11, 1, 'admin/wx/commission', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:25:33', '2020-05-02 14:25:33');
INSERT INTO `admin_operation_log` VALUES (12, 1, 'admin/wx/commission', 'GET', '127.0.0.1', '[]', '2020-05-02 14:29:14', '2020-05-02 14:29:14');
INSERT INTO `admin_operation_log` VALUES (13, 1, 'admin/wx/commission', 'GET', '127.0.0.1', '[]', '2020-05-02 14:30:36', '2020-05-02 14:30:36');
INSERT INTO `admin_operation_log` VALUES (14, 1, 'admin/wx/commission', 'GET', '127.0.0.1', '[]', '2020-05-02 14:31:29', '2020-05-02 14:31:29');
INSERT INTO `admin_operation_log` VALUES (15, 1, 'admin/wx/commission', 'GET', '127.0.0.1', '[]', '2020-05-02 14:34:11', '2020-05-02 14:34:11');
INSERT INTO `admin_operation_log` VALUES (16, 1, 'admin/wx/commission', 'GET', '127.0.0.1', '[]', '2020-05-02 14:34:31', '2020-05-02 14:34:31');
INSERT INTO `admin_operation_log` VALUES (17, 1, 'admin/wx/commission', 'GET', '127.0.0.1', '[]', '2020-05-02 14:34:59', '2020-05-02 14:34:59');
INSERT INTO `admin_operation_log` VALUES (18, 1, 'admin/wx/commission', 'GET', '127.0.0.1', '[]', '2020-05-02 14:37:31', '2020-05-02 14:37:31');
INSERT INTO `admin_operation_log` VALUES (19, 1, 'admin/wx/orders', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:37:40', '2020-05-02 14:37:40');
INSERT INTO `admin_operation_log` VALUES (20, 1, 'admin/wx/goods', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:37:44', '2020-05-02 14:37:44');
INSERT INTO `admin_operation_log` VALUES (21, 1, 'admin/wx/orders', 'GET', '127.0.0.1', '[]', '2020-05-02 14:38:07', '2020-05-02 14:38:07');
INSERT INTO `admin_operation_log` VALUES (22, 1, 'admin/wx/orders', 'GET', '127.0.0.1', '[]', '2020-05-02 14:42:05', '2020-05-02 14:42:05');
INSERT INTO `admin_operation_log` VALUES (23, 1, 'admin/wx/goods', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:42:13', '2020-05-02 14:42:13');
INSERT INTO `admin_operation_log` VALUES (24, 1, 'admin/wx/goods', 'GET', '127.0.0.1', '[]', '2020-05-02 14:43:29', '2020-05-02 14:43:29');
INSERT INTO `admin_operation_log` VALUES (25, 1, 'admin/wx/goods', 'GET', '127.0.0.1', '[]', '2020-05-02 14:43:59', '2020-05-02 14:43:59');
INSERT INTO `admin_operation_log` VALUES (26, 1, 'admin/specifications', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:44:06', '2020-05-02 14:44:06');
INSERT INTO `admin_operation_log` VALUES (27, 1, 'admin/wx/goods', 'GET', '127.0.0.1', '[]', '2020-05-02 14:44:28', '2020-05-02 14:44:28');
INSERT INTO `admin_operation_log` VALUES (28, 1, 'admin/wx/goods', 'GET', '127.0.0.1', '[]', '2020-05-02 14:45:27', '2020-05-02 14:45:27');
INSERT INTO `admin_operation_log` VALUES (29, 1, 'admin/wx/goods/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:45:33', '2020-05-02 14:45:33');
INSERT INTO `admin_operation_log` VALUES (30, 1, 'admin/specifications', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:45:48', '2020-05-02 14:45:48');
INSERT INTO `admin_operation_log` VALUES (31, 1, 'admin/wx/goods/create', 'GET', '127.0.0.1', '[]', '2020-05-02 14:46:10', '2020-05-02 14:46:10');
INSERT INTO `admin_operation_log` VALUES (32, 1, 'admin/specifications', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:48:48', '2020-05-02 14:48:48');
INSERT INTO `admin_operation_log` VALUES (33, 1, 'admin/specifications/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:48:51', '2020-05-02 14:48:51');
INSERT INTO `admin_operation_log` VALUES (34, 1, 'admin/wx/categories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:49:05', '2020-05-02 14:49:05');
INSERT INTO `admin_operation_log` VALUES (35, 1, 'admin/wx/categories/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:49:11', '2020-05-02 14:49:11');
INSERT INTO `admin_operation_log` VALUES (36, 1, 'admin/wx/categories', 'POST', '127.0.0.1', '{\"name\":\"test\\u680f\\u76ee\",\"parent_id\":null,\"level\":\"0\",\"_token\":\"UgRdFt1kq8NYQh8vvaFWpjtN7ca3POSJ7Y86ta5N\",\"_previous_\":\"http:\\/\\/shopmall.com\\/admin\\/wx\\/categories\"}', '2020-05-02 14:49:29', '2020-05-02 14:49:29');
INSERT INTO `admin_operation_log` VALUES (37, 1, 'admin/wx/categories', 'GET', '127.0.0.1', '[]', '2020-05-02 14:49:30', '2020-05-02 14:49:30');
INSERT INTO `admin_operation_log` VALUES (38, 1, 'admin/wx/categories/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:49:33', '2020-05-02 14:49:33');
INSERT INTO `admin_operation_log` VALUES (39, 1, 'admin/wx/categories', 'POST', '127.0.0.1', '{\"name\":\"test\\u4e8c\\u7ea7\\u680f\\u76ee\",\"parent_id\":\"1\",\"level\":\"1\",\"_token\":\"UgRdFt1kq8NYQh8vvaFWpjtN7ca3POSJ7Y86ta5N\",\"_previous_\":\"http:\\/\\/shopmall.com\\/admin\\/wx\\/categories\"}', '2020-05-02 14:49:47', '2020-05-02 14:49:47');
INSERT INTO `admin_operation_log` VALUES (40, 1, 'admin/wx/categories', 'GET', '127.0.0.1', '[]', '2020-05-02 14:49:48', '2020-05-02 14:49:48');
INSERT INTO `admin_operation_log` VALUES (41, 1, 'admin/wx/advertises', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:50:04', '2020-05-02 14:50:04');
INSERT INTO `admin_operation_log` VALUES (42, 1, 'admin/wx/categories', 'GET', '127.0.0.1', '[]', '2020-05-02 14:50:21', '2020-05-02 14:50:21');
INSERT INTO `admin_operation_log` VALUES (43, 1, 'admin/wx/advertises', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:50:54', '2020-05-02 14:50:54');
INSERT INTO `admin_operation_log` VALUES (44, 1, 'admin/wx/advertises/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:50:56', '2020-05-02 14:50:56');
INSERT INTO `admin_operation_log` VALUES (45, 1, 'admin/wx/advertises', 'POST', '127.0.0.1', '{\"image\":\"\\u5355\\u72ec\",\"position\":\"3468\",\"_token\":\"UgRdFt1kq8NYQh8vvaFWpjtN7ca3POSJ7Y86ta5N\",\"_previous_\":\"http:\\/\\/shopmall.com\\/admin\\/wx\\/advertises\"}', '2020-05-02 14:51:22', '2020-05-02 14:51:22');
INSERT INTO `admin_operation_log` VALUES (46, 1, 'admin/wx/advertises/create', 'GET', '127.0.0.1', '[]', '2020-05-02 14:51:27', '2020-05-02 14:51:27');
INSERT INTO `admin_operation_log` VALUES (47, 1, 'admin/wx/advertises/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:53:28', '2020-05-02 14:53:28');
INSERT INTO `admin_operation_log` VALUES (48, 1, 'admin/wx/advertises', 'POST', '127.0.0.1', '{\"position\":\"34546\",\"_token\":\"UgRdFt1kq8NYQh8vvaFWpjtN7ca3POSJ7Y86ta5N\"}', '2020-05-02 14:53:41', '2020-05-02 14:53:41');
INSERT INTO `admin_operation_log` VALUES (49, 1, 'admin/wx/advertises', 'GET', '127.0.0.1', '[]', '2020-05-02 14:53:42', '2020-05-02 14:53:42');
INSERT INTO `admin_operation_log` VALUES (50, 1, 'admin/wx/advertises', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:54:24', '2020-05-02 14:54:24');
INSERT INTO `admin_operation_log` VALUES (51, 1, 'admin/wx/reply', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:54:30', '2020-05-02 14:54:30');
INSERT INTO `admin_operation_log` VALUES (52, 1, 'admin/wx/advertises', 'GET', '127.0.0.1', '[]', '2020-05-02 14:54:50', '2020-05-02 14:54:50');
INSERT INTO `admin_operation_log` VALUES (53, 1, 'admin/wx/reply', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:55:27', '2020-05-02 14:55:27');
INSERT INTO `admin_operation_log` VALUES (54, 1, 'admin/wx/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:56:03', '2020-05-02 14:56:03');
INSERT INTO `admin_operation_log` VALUES (55, 1, 'admin/wx/users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:56:07', '2020-05-02 14:56:07');
INSERT INTO `admin_operation_log` VALUES (56, 1, 'admin/wx/goods', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:57:33', '2020-05-02 14:57:33');
INSERT INTO `admin_operation_log` VALUES (57, 1, 'admin/wx/goods/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 14:57:35', '2020-05-02 14:57:35');
INSERT INTO `admin_operation_log` VALUES (58, 1, 'admin/wx/goods', 'POST', '127.0.0.1', '{\"title\":\"\\u534e\\u4e3a-P30\",\"description\":null,\"on_hot\":\"on\",\"on_sale\":\"on\",\"content\":\"\\u9876\\u9876\\u9876\",\"express_price\":\"3000\",\"price\":\"2000\",\"rating\":\"5\",\"category_id\":\"2\",\"good_no\":null,\"stock\":\"70\",\"_token\":\"UgRdFt1kq8NYQh8vvaFWpjtN7ca3POSJ7Y86ta5N\",\"_previous_\":\"http:\\/\\/shopmall.com\\/admin\\/wx\\/goods\"}', '2020-05-02 15:00:19', '2020-05-02 15:00:19');
INSERT INTO `admin_operation_log` VALUES (59, 1, 'admin/wx/goods/create', 'GET', '127.0.0.1', '[]', '2020-05-02 15:00:21', '2020-05-02 15:00:21');
INSERT INTO `admin_operation_log` VALUES (60, 1, 'admin/wx/goods', 'POST', '127.0.0.1', '{\"title\":\"\\u534e\\u4e3a-P30\",\"description\":null,\"on_hot\":\"on\",\"on_sale\":\"on\",\"content\":\"\\u9876\\u9876\\u9876\",\"express_price\":\"3000\",\"price\":\"2000\",\"rating\":\"5\",\"category_id\":\"2\",\"good_no\":null,\"stock\":\"70\",\"_token\":\"UgRdFt1kq8NYQh8vvaFWpjtN7ca3POSJ7Y86ta5N\"}', '2020-05-02 15:00:50', '2020-05-02 15:00:50');
INSERT INTO `admin_operation_log` VALUES (61, 1, 'admin/wx/goods', 'GET', '127.0.0.1', '[]', '2020-05-02 15:00:51', '2020-05-02 15:00:51');
INSERT INTO `admin_operation_log` VALUES (62, 1, 'admin/wx/goods/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:00:58', '2020-05-02 15:00:58');
INSERT INTO `admin_operation_log` VALUES (63, 1, 'admin/wx/goods/1/edit', 'GET', '127.0.0.1', '[]', '2020-05-02 15:03:16', '2020-05-02 15:03:16');
INSERT INTO `admin_operation_log` VALUES (64, 1, 'admin/wx/goods/1/edit', 'GET', '127.0.0.1', '[]', '2020-05-02 15:04:05', '2020-05-02 15:04:05');
INSERT INTO `admin_operation_log` VALUES (65, 1, 'admin/wx/goods/1/edit', 'GET', '127.0.0.1', '[]', '2020-05-02 15:08:12', '2020-05-02 15:08:12');
INSERT INTO `admin_operation_log` VALUES (66, 1, 'admin/wx/goods/1', 'PUT', '127.0.0.1', '{\"title\":\"\\u534e\\u4e3a-P30\",\"description\":null,\"on_hot\":\"on\",\"on_sale\":\"on\",\"content\":\"<p>\\u9876\\u9876\\u9876<\\/p>\",\"express_price\":\"3000\",\"price\":\"2000\",\"rating\":\"5\",\"category_id\":\"2\",\"good_no\":null,\"stock\":\"70\",\"images\":{\"new_1\":{\"description\":\"text\",\"id\":null,\"_remove_\":\"0\"},\"new_2\":{\"description\":\"text2\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"UgRdFt1kq8NYQh8vvaFWpjtN7ca3POSJ7Y86ta5N\",\"_method\":\"PUT\"}', '2020-05-02 15:08:47', '2020-05-02 15:08:47');
INSERT INTO `admin_operation_log` VALUES (67, 1, 'admin/wx/goods', 'GET', '127.0.0.1', '[]', '2020-05-02 15:08:47', '2020-05-02 15:08:47');
INSERT INTO `admin_operation_log` VALUES (68, 1, 'admin/goods/1/images', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:08:51', '2020-05-02 15:08:51');
INSERT INTO `admin_operation_log` VALUES (69, 1, 'admin/wx/goods', 'GET', '127.0.0.1', '[]', '2020-05-02 15:09:01', '2020-05-02 15:09:01');
INSERT INTO `admin_operation_log` VALUES (70, 1, 'admin/goods/1/images', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:09:35', '2020-05-02 15:09:35');
INSERT INTO `admin_operation_log` VALUES (71, 1, 'admin/wx/goods', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:11:39', '2020-05-02 15:11:39');
INSERT INTO `admin_operation_log` VALUES (72, 1, 'admin/wx/goods/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:12:02', '2020-05-02 15:12:02');
INSERT INTO `admin_operation_log` VALUES (73, 1, 'admin/wx/goods', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:12:13', '2020-05-02 15:12:13');
INSERT INTO `admin_operation_log` VALUES (74, 1, 'admin/specifications', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:12:22', '2020-05-02 15:12:22');
INSERT INTO `admin_operation_log` VALUES (75, 1, 'admin/specifications/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:12:24', '2020-05-02 15:12:24');
INSERT INTO `admin_operation_log` VALUES (76, 1, 'admin/specifications', 'POST', '127.0.0.1', '{\"good_id\":\"1\",\"title\":\"\\u5185\\u5b58,\\u5b58\\u50a8\\u7a7a\\u95f4\",\"description\":\"8G,32G\",\"price\":\"2000\",\"stock\":\"50\",\"_token\":\"UgRdFt1kq8NYQh8vvaFWpjtN7ca3POSJ7Y86ta5N\",\"_previous_\":\"http:\\/\\/shopmall.com\\/admin\\/specifications\"}', '2020-05-02 15:12:39', '2020-05-02 15:12:39');
INSERT INTO `admin_operation_log` VALUES (77, 1, 'admin/specifications', 'GET', '127.0.0.1', '[]', '2020-05-02 15:12:39', '2020-05-02 15:12:39');
INSERT INTO `admin_operation_log` VALUES (78, 1, 'admin/specifications/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:12:45', '2020-05-02 15:12:45');
INSERT INTO `admin_operation_log` VALUES (79, 1, 'admin/specifications', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:12:49', '2020-05-02 15:12:49');
INSERT INTO `admin_operation_log` VALUES (80, 1, 'admin/wx/categories', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:12:50', '2020-05-02 15:12:50');
INSERT INTO `admin_operation_log` VALUES (81, 1, 'admin/wx/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:12:59', '2020-05-02 15:12:59');
INSERT INTO `admin_operation_log` VALUES (82, 1, 'admin/wx/users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:13:03', '2020-05-02 15:13:03');
INSERT INTO `admin_operation_log` VALUES (83, 1, 'admin/wx/users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:14:41', '2020-05-02 15:14:41');
INSERT INTO `admin_operation_log` VALUES (84, 1, 'admin/wx/users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:15:20', '2020-05-02 15:15:20');
INSERT INTO `admin_operation_log` VALUES (85, 1, 'admin/wx/users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:15:59', '2020-05-02 15:15:59');
INSERT INTO `admin_operation_log` VALUES (86, 1, 'admin/wx/users/create', 'GET', '127.0.0.1', '[]', '2020-05-02 15:16:03', '2020-05-02 15:16:03');
INSERT INTO `admin_operation_log` VALUES (87, 1, 'admin/wx/users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:17:17', '2020-05-02 15:17:17');
INSERT INTO `admin_operation_log` VALUES (88, 1, 'admin/wx/users/create', 'GET', '127.0.0.1', '[]', '2020-05-02 15:17:29', '2020-05-02 15:17:29');
INSERT INTO `admin_operation_log` VALUES (89, 1, 'admin/wx/users', 'POST', '127.0.0.1', '{\"name\":\"fff\",\"phone\":\"15312132121\",\"info\":{\"type\":\"0\",\"gender\":\"0\"},\"password\":null,\"_token\":\"UgRdFt1kq8NYQh8vvaFWpjtN7ca3POSJ7Y86ta5N\"}', '2020-05-02 15:18:03', '2020-05-02 15:18:03');
INSERT INTO `admin_operation_log` VALUES (90, 1, 'admin/wx/users', 'GET', '127.0.0.1', '[]', '2020-05-02 15:18:03', '2020-05-02 15:18:03');
INSERT INTO `admin_operation_log` VALUES (91, 1, 'admin/wx/users/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:18:50', '2020-05-02 15:18:50');
INSERT INTO `admin_operation_log` VALUES (92, 1, 'admin/wx/users', 'POST', '127.0.0.1', '{\"name\":\"test\",\"phone\":\"15312132121\",\"info\":{\"type\":\"0\",\"gender\":\"0\"},\"password\":\"123123\",\"_token\":\"UgRdFt1kq8NYQh8vvaFWpjtN7ca3POSJ7Y86ta5N\",\"_previous_\":\"http:\\/\\/shopmall.com\\/admin\\/wx\\/users\"}', '2020-05-02 15:21:57', '2020-05-02 15:21:57');
INSERT INTO `admin_operation_log` VALUES (93, 1, 'admin/wx/users/create', 'GET', '127.0.0.1', '[]', '2020-05-02 15:21:57', '2020-05-02 15:21:57');
INSERT INTO `admin_operation_log` VALUES (94, 1, 'admin/wx/users', 'POST', '127.0.0.1', '{\"name\":\"test\",\"phone\":\"15312132121\",\"info\":{\"type\":\"0\",\"gender\":\"0\"},\"password\":\"123123\",\"_token\":\"UgRdFt1kq8NYQh8vvaFWpjtN7ca3POSJ7Y86ta5N\"}', '2020-05-02 15:23:21', '2020-05-02 15:23:21');
INSERT INTO `admin_operation_log` VALUES (95, 1, 'admin/wx/users/create', 'GET', '127.0.0.1', '[]', '2020-05-02 15:23:22', '2020-05-02 15:23:22');
INSERT INTO `admin_operation_log` VALUES (96, 1, 'admin/wx/users', 'POST', '127.0.0.1', '{\"name\":\"test\",\"phone\":\"15312132120\",\"info\":{\"type\":\"0\",\"gender\":\"0\"},\"password\":\"123123\",\"_token\":\"UgRdFt1kq8NYQh8vvaFWpjtN7ca3POSJ7Y86ta5N\"}', '2020-05-02 15:23:30', '2020-05-02 15:23:30');
INSERT INTO `admin_operation_log` VALUES (97, 1, 'admin/wx/users', 'GET', '127.0.0.1', '[]', '2020-05-02 15:23:30', '2020-05-02 15:23:30');
INSERT INTO `admin_operation_log` VALUES (98, 1, 'admin/wx/users/2/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:23:37', '2020-05-02 15:23:37');
INSERT INTO `admin_operation_log` VALUES (99, 1, 'admin/wx/users/2', 'PUT', '127.0.0.1', '{\"name\":\"test\",\"phone\":\"15312132120\",\"info\":{\"type\":\"1\",\"gender\":\"1\"},\"password\":null,\"_token\":\"UgRdFt1kq8NYQh8vvaFWpjtN7ca3POSJ7Y86ta5N\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/shopmall.com\\/admin\\/wx\\/users\"}', '2020-05-02 15:23:44', '2020-05-02 15:23:44');
INSERT INTO `admin_operation_log` VALUES (100, 1, 'admin/wx/users', 'GET', '127.0.0.1', '[]', '2020-05-02 15:23:45', '2020-05-02 15:23:45');
INSERT INTO `admin_operation_log` VALUES (101, 1, 'admin/wx/levels', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:23:57', '2020-05-02 15:23:57');
INSERT INTO `admin_operation_log` VALUES (102, 1, 'admin/wx/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:25:36', '2020-05-02 15:25:36');
INSERT INTO `admin_operation_log` VALUES (103, 1, 'admin/wx/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:25:56', '2020-05-02 15:25:56');
INSERT INTO `admin_operation_log` VALUES (104, 1, 'admin/wx/users', 'GET', '127.0.0.1', '[]', '2020-05-02 15:32:24', '2020-05-02 15:32:24');
INSERT INTO `admin_operation_log` VALUES (105, 1, 'admin/wx/users', 'GET', '127.0.0.1', '[]', '2020-05-02 15:34:12', '2020-05-02 15:34:12');
INSERT INTO `admin_operation_log` VALUES (106, 1, 'admin/wx/users', 'GET', '127.0.0.1', '[]', '2020-05-02 15:36:45', '2020-05-02 15:36:45');
INSERT INTO `admin_operation_log` VALUES (107, 1, 'admin/wx/users', 'GET', '127.0.0.1', '[]', '2020-05-02 15:41:00', '2020-05-02 15:41:00');
INSERT INTO `admin_operation_log` VALUES (108, 1, 'admin/wx/users', 'GET', '127.0.0.1', '[]', '2020-05-02 15:41:37', '2020-05-02 15:41:37');
INSERT INTO `admin_operation_log` VALUES (109, 1, 'admin/wx/users', 'GET', '127.0.0.1', '[]', '2020-05-02 15:47:38', '2020-05-02 15:47:38');
INSERT INTO `admin_operation_log` VALUES (110, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:47:56', '2020-05-02 15:47:56');
INSERT INTO `admin_operation_log` VALUES (111, 1, 'admin/auth/menu/10', 'DELETE', '127.0.0.1', '{\"_method\":\"delete\",\"_token\":\"UgRdFt1kq8NYQh8vvaFWpjtN7ca3POSJ7Y86ta5N\"}', '2020-05-02 15:48:02', '2020-05-02 15:48:02');
INSERT INTO `admin_operation_log` VALUES (112, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-05-02 15:48:02', '2020-05-02 15:48:02');

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `http_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_permissions_name_unique`(`name`) USING BTREE,
  UNIQUE INDEX `admin_permissions_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
INSERT INTO `admin_permissions` VALUES (1, 'All permission', '*', '', '*', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (2, 'Dashboard', 'dashboard', 'GET', '/', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (3, 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (4, 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (5, 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, NULL);

-- ----------------------------
-- Table structure for admin_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE `admin_role_menu`  (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_role_menu_role_id_menu_id_index`(`role_id`, `menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_menu
-- ----------------------------
INSERT INTO `admin_role_menu` VALUES (1, 2, NULL, NULL);

-- ----------------------------
-- Table structure for admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions`  (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_role_permissions_role_id_permission_id_index`(`role_id`, `permission_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_permissions
-- ----------------------------
INSERT INTO `admin_role_permissions` VALUES (1, 1, NULL, NULL);

-- ----------------------------
-- Table structure for admin_role_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users`  (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_role_users_role_id_user_id_index`(`role_id`, `user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_users
-- ----------------------------
INSERT INTO `admin_role_users` VALUES (1, 1, NULL, NULL);

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_roles_name_unique`(`name`) USING BTREE,
  UNIQUE INDEX `admin_roles_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES (1, 'Administrator', 'administrator', '2020-05-02 14:16:32', '2020-05-02 14:16:32');

-- ----------------------------
-- Table structure for admin_user_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_permissions`;
CREATE TABLE `admin_user_permissions`  (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_user_permissions_user_id_permission_id_index`(`user_id`, `permission_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_users_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES (1, 'admin', '$2y$10$LqjSoRxTIS.KpEnOWvqWRO0c1CrYX.SWdtKZxjAIlpS4Wryd9QUA.', 'Administrator', NULL, 'wxsYKXA8Vy8jiqkWdxnU977MfBQQm851G2lMdADOcWtgSrZVp72UZjMLhsll', '2020-05-02 14:16:31', '2020-05-02 14:16:31');

-- ----------------------------
-- Table structure for ads
-- ----------------------------
DROP TABLE IF EXISTS `ads`;
CREATE TABLE `ads`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '广告类型',
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '广告位编号-前端约定',
  `good_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '产品id',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ads
-- ----------------------------
INSERT INTO `ads` VALUES (1, 'images/261798abb01f4af5e2508084af0a0588.jpg', '34546', NULL, '2020-05-02 14:53:42', '2020-05-02 14:53:42');

-- ----------------------------
-- Table structure for bounses
-- ----------------------------
DROP TABLE IF EXISTS `bounses`;
CREATE TABLE `bounses`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) NOT NULL COMMENT '外键用户ID',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `user_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0-普通客户 1-二级代销 2-一级代销',
  `bonus` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '返利金额',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `bounses_user_id_index`(`user_id`) USING BTREE,
  INDEX `bounses_order_id_index`(`order_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cart_items
-- ----------------------------
DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE `cart_items`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT '外键用户id',
  `good_id` bigint(20) UNSIGNED NOT NULL COMMENT '外键商品id',
  `cartExist` tinyint(1) NULL DEFAULT NULL COMMENT '是否在购物车内，不是则是立即购买',
  `amount` bigint(20) UNSIGNED NOT NULL COMMENT '购买数量',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分类名称',
  `parent_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '父类id',
  `is_directory` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否拥有子类',
  `level` int(10) UNSIGNED NOT NULL COMMENT '当前分类层级',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '该分类所有父类id',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `categories_name_unique`(`name`) USING BTREE,
  INDEX `categories_parent_id_foreign`(`parent_id`) USING BTREE,
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'test栏目', NULL, 1, 0, NULL, '2020-05-02 14:49:29', NULL);
INSERT INTO `categories` VALUES (2, 'test二级栏目', 1, 0, 1, NULL, '2020-05-02 14:49:47', NULL);

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for good_images
-- ----------------------------
DROP TABLE IF EXISTS `good_images`;
CREATE TABLE `good_images`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '商品图片描述',
  `good_id` bigint(20) UNSIGNED NOT NULL COMMENT '外键商品id',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品图片',
  `cover` tinyint(1) NOT NULL DEFAULT 1 COMMENT '商品封面-浏览的第一张图片',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `good_images_good_id_index`(`good_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of good_images
-- ----------------------------
INSERT INTO `good_images` VALUES (1, 'text', 1, 'images/7177bc5ec5f810e2dec34c3a19adf431.jpg', 1, '2020-05-02 15:08:47', '2020-05-02 15:08:47');
INSERT INTO `good_images` VALUES (2, 'text2', 1, 'images/077a32aa0167258797257978edceac8c.jpg', 1, '2020-05-02 15:08:47', '2020-05-02 15:08:47');

-- ----------------------------
-- Table structure for good_skus
-- ----------------------------
DROP TABLE IF EXISTS `good_skus`;
CREATE TABLE `good_skus`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'sku商品名称',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'sku商品描述',
  `price` decimal(10, 2) NOT NULL COMMENT 'sku商品价格',
  `stock` int(10) UNSIGNED NOT NULL COMMENT 'sku商品数量',
  `good_id` bigint(20) UNSIGNED NOT NULL COMMENT '外键商品id',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `good_skus_good_id_foreign`(`good_id`) USING BTREE,
  CONSTRAINT `good_skus_good_id_foreign` FOREIGN KEY (`good_id`) REFERENCES `goods` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of good_skus
-- ----------------------------
INSERT INTO `good_skus` VALUES (1, '内存,存储空间', '8G,32G', 2000.00, 50, 1, '2020-05-02 15:12:39', '2020-05-02 15:12:39');

-- ----------------------------
-- Table structure for goods
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品名称',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '商品描述',
  `on_hot` tinyint(1) NOT NULL DEFAULT 1 COMMENT '推荐标识',
  `on_sale` tinyint(1) NOT NULL DEFAULT 1 COMMENT '上架标识',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品详情',
  `express_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '市场价',
  `price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '售价',
  `rating` double(8, 2) NOT NULL DEFAULT 5.00 COMMENT '星级平均评分',
  `category_id` int(11) NOT NULL COMMENT '分类id',
  `good_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '货号',
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '库存',
  `sold_count` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '销量',
  `review_count` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '浏览量',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `category_id`(`category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES (1, '华为-P30', NULL, 1, 1, '<p>顶顶顶</p>', 3000.00, 2000.00, 5.00, 2, NULL, 70, 0, 0, '2020-05-02 15:00:50', '2020-05-02 15:08:47');

-- ----------------------------
-- Table structure for images
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) NOT NULL COMMENT '外键user_id',
  `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户图片类型',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图片相对路径',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `images_user_id_index`(`user_id`) USING BTREE,
  INDEX `images_type_index`(`type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2016_01_04_173148_create_admin_tables', 1);
INSERT INTO `migrations` VALUES (4, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (5, '2020_03_17_200736_create_reply_images_table', 1);
INSERT INTO `migrations` VALUES (6, '2020_04_20_042521_create_images_table', 1);
INSERT INTO `migrations` VALUES (7, '2020_04_20_042545_create_categories_table', 1);
INSERT INTO `migrations` VALUES (8, '2020_04_20_042613_create_user_infos_table', 1);
INSERT INTO `migrations` VALUES (9, '2020_04_20_042640_create_user_addresses_table', 1);
INSERT INTO `migrations` VALUES (10, '2020_04_20_042712_create_goods_table', 1);
INSERT INTO `migrations` VALUES (11, '2020_04_20_042813_create_good_images_table', 1);
INSERT INTO `migrations` VALUES (12, '2020_04_20_042858_create_cart_items_table', 1);
INSERT INTO `migrations` VALUES (13, '2020_04_20_042936_create_orders_table', 1);
INSERT INTO `migrations` VALUES (14, '2020_04_20_042953_create_order_items_table', 1);
INSERT INTO `migrations` VALUES (15, '2020_04_20_043017_create_ads_table', 1);
INSERT INTO `migrations` VALUES (16, '2020_04_20_043034_create_replies_table', 1);
INSERT INTO `migrations` VALUES (17, '2020_04_20_132349_create_good_skus_table', 1);
INSERT INTO `migrations` VALUES (18, '2020_04_20_132431_create_bonuses_table', 1);
INSERT INTO `migrations` VALUES (19, '2020_04_28_204244_create_user_favorite_goods_table', 1);
INSERT INTO `migrations` VALUES (20, '2020_05_01_210201_add_rating_to_replies_table', 1);

-- ----------------------------
-- Table structure for order_items
-- ----------------------------
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `order_id` bigint(20) UNSIGNED NOT NULL COMMENT '外键订单id',
  `good_id` bigint(20) UNSIGNED NOT NULL COMMENT '外键商品id',
  `amount` int(10) UNSIGNED NOT NULL COMMENT '数量',
  `price` decimal(10, 2) NOT NULL COMMENT '单价',
  `rating` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '评分',
  `reviewed_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号',
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT '外键用户id',
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户地址',
  `total_amount` decimal(10, 2) NOT NULL COMMENT '订单总价',
  `remark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '订单备注',
  `paid_at` datetime(0) NULL DEFAULT NULL COMMENT '支付时间',
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '支付方式',
  `payment_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '支付流水号',
  `user_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '用户类型 0-普通客户 1-二级代销 2-一级代销',
  `bonus` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '订单返利',
  `refund_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'refund_pending' COMMENT '退款退货状态',
  `refund_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '退款退货单号',
  `closed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '订单是否关闭',
  `reply_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '订单是否已评价',
  `cancel` tinyint(1) NOT NULL DEFAULT 0 COMMENT '订单是否取消',
  `ship_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ship_pending' COMMENT '订单物流状态',
  `ship_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '物流信息',
  `extra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '其他订单额外数据',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `orders_no_unique`(`no`) USING BTREE,
  UNIQUE INDEX `orders_refund_no_unique`(`refund_no`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for replies
-- ----------------------------
DROP TABLE IF EXISTS `replies`;
CREATE TABLE `replies`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `good_id` int(11) NOT NULL COMMENT '外键商品id',
  `user_id` int(11) NOT NULL COMMENT '外键用户id',
  `order_id` int(11) NOT NULL COMMENT '外键订单id',
  `rating` decimal(8, 2) NOT NULL DEFAULT 5.00,
  `images` json NULL COMMENT '评论图片json数组',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '评论描述',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `replies_good_id_index`(`good_id`) USING BTREE,
  INDEX `replies_user_id_index`(`user_id`) USING BTREE,
  INDEX `replies_order_id_index`(`order_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reply_images
-- ----------------------------
DROP TABLE IF EXISTS `reply_images`;
CREATE TABLE `reply_images`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `good_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `reply_images_good_id_index`(`good_id`) USING BTREE,
  INDEX `reply_images_user_id_index`(`user_id`) USING BTREE,
  INDEX `reply_images_order_id_index`(`order_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_addresses
-- ----------------------------
DROP TABLE IF EXISTS `user_addresses`;
CREATE TABLE `user_addresses`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) NOT NULL COMMENT '外键用户id',
  `province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '省',
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '市',
  `district` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '区',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '地址',
  `zip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮编',
  `contact_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '收货人姓名',
  `contact_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '收货人手机号',
  `default_address` tinyint(1) NOT NULL DEFAULT 0 COMMENT '默认地址标识',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_addresses_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_favorite_goods
-- ----------------------------
DROP TABLE IF EXISTS `user_favorite_goods`;
CREATE TABLE `user_favorite_goods`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `good_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_favorite_goods_user_id_foreign`(`user_id`) USING BTREE,
  INDEX `user_favorite_goods_good_id_foreign`(`good_id`) USING BTREE,
  CONSTRAINT `user_favorite_goods_good_id_foreign` FOREIGN KEY (`good_id`) REFERENCES `goods` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `user_favorite_goods_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_infos
-- ----------------------------
DROP TABLE IF EXISTS `user_infos`;
CREATE TABLE `user_infos`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) NOT NULL COMMENT '外键user_id',
  `parent_id` int(11) NULL DEFAULT NULL COMMENT '上级id',
  `type` smallint(6) NOT NULL DEFAULT 0 COMMENT '账号类别：0-普通用户,1-二级代理,2-一级代理',
  `gender` smallint(6) NOT NULL DEFAULT 0 COMMENT '性别:0-保密,1-男,2-女',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_infos_user_id_index`(`user_id`) USING BTREE,
  INDEX `user_infos_parent_id_index`(`parent_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_infos
-- ----------------------------
INSERT INTO `user_infos` VALUES (1, 1, NULL, 0, 0, '2020-05-02 15:18:03', '2020-05-02 15:18:03');
INSERT INTO `user_infos` VALUES (2, 2, NULL, 1, 1, '2020-05-02 15:23:30', '2020-05-02 15:23:44');
INSERT INTO `user_infos` VALUES (3, 3, NULL, 1, 2, '2003-12-12 09:55:02', NULL);
INSERT INTO `user_infos` VALUES (4, 4, NULL, 2, 0, '2003-08-31 11:28:15', NULL);
INSERT INTO `user_infos` VALUES (5, 5, NULL, 0, 1, '1984-11-13 05:09:37', NULL);
INSERT INTO `user_infos` VALUES (6, 6, NULL, 0, 1, '2012-09-21 15:44:01', NULL);
INSERT INTO `user_infos` VALUES (7, 7, NULL, 2, 2, '2007-01-26 01:15:16', NULL);
INSERT INTO `user_infos` VALUES (8, 8, NULL, 2, 0, '2007-05-03 16:51:01', NULL);
INSERT INTO `user_infos` VALUES (9, 9, NULL, 1, 0, '2019-08-25 22:29:11', NULL);
INSERT INTO `user_infos` VALUES (10, 10, NULL, 0, 1, '2010-11-12 01:52:08', NULL);
INSERT INTO `user_infos` VALUES (11, 11, NULL, 0, 1, '2006-09-05 13:41:31', NULL);
INSERT INTO `user_infos` VALUES (12, 12, NULL, 0, 1, '2018-09-01 04:30:52', NULL);
INSERT INTO `user_infos` VALUES (13, 13, NULL, 0, 0, '1979-07-31 05:00:00', NULL);
INSERT INTO `user_infos` VALUES (14, 14, NULL, 0, 0, '1982-03-31 15:35:35', NULL);
INSERT INTO `user_infos` VALUES (15, 15, NULL, 0, 1, '2012-11-29 14:30:43', NULL);
INSERT INTO `user_infos` VALUES (16, 16, NULL, 2, 2, '1974-10-20 22:51:54', NULL);
INSERT INTO `user_infos` VALUES (17, 17, NULL, 0, 2, '2012-03-03 07:16:07', NULL);
INSERT INTO `user_infos` VALUES (18, 18, NULL, 1, 2, '2004-09-12 00:17:18', NULL);
INSERT INTO `user_infos` VALUES (19, 19, NULL, 0, 1, '2005-02-22 20:46:17', NULL);
INSERT INTO `user_infos` VALUES (20, 20, NULL, 2, 0, '1986-07-19 10:50:47', NULL);
INSERT INTO `user_infos` VALUES (21, 21, NULL, 2, 0, '2007-03-15 00:53:33', NULL);
INSERT INTO `user_infos` VALUES (22, 22, NULL, 0, 1, '1997-08-24 10:51:03', NULL);
INSERT INTO `user_infos` VALUES (23, 23, NULL, 2, 1, '1985-08-23 02:58:05', NULL);
INSERT INTO `user_infos` VALUES (24, 24, NULL, 2, 0, '2002-10-09 11:09:06', NULL);
INSERT INTO `user_infos` VALUES (25, 25, NULL, 1, 2, '2002-04-02 14:19:40', NULL);
INSERT INTO `user_infos` VALUES (26, 26, NULL, 1, 2, '2001-02-07 09:36:46', NULL);
INSERT INTO `user_infos` VALUES (27, 27, NULL, 2, 0, '2003-06-03 13:16:54', NULL);
INSERT INTO `user_infos` VALUES (28, 28, NULL, 2, 1, '1981-09-15 17:46:02', NULL);
INSERT INTO `user_infos` VALUES (29, 29, NULL, 2, 2, '1978-09-08 20:36:39', NULL);
INSERT INTO `user_infos` VALUES (30, 30, NULL, 0, 1, '1986-05-30 06:43:35', NULL);
INSERT INTO `user_infos` VALUES (31, 31, NULL, 0, 1, '1979-04-28 19:36:12', NULL);
INSERT INTO `user_infos` VALUES (32, 32, NULL, 0, 1, '2008-02-11 08:34:11', NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '微信昵称',
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户手机号',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '微信头像',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '登录密码',
  `session_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '小程序session_key',
  `open_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '小程序open_id',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_phone_unique`(`phone`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'fff', '15312132121', NULL, '$2y$10$kz4qbB1DzvACk8la2UMI/O9kSVY3ysr1reL6EgK0gSBN4U0eqnL9y', NULL, NULL, NULL, '2020-05-02 15:18:03', '2020-05-02 15:18:03');
INSERT INTO `users` VALUES (2, 'test', '15312132120', NULL, '$2y$10$OxyHjL6ftBiLu2G6awJIJOjzRJ6svrooodk5LyGt3kjoG0fmq1yZ6', NULL, NULL, NULL, '2020-05-02 15:23:30', '2020-05-02 15:23:44');
INSERT INTO `users` VALUES (3, 'Savion Wisoky', '+1981910924', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1997-10-18 17:32:11', NULL);
INSERT INTO `users` VALUES (4, 'Herminio Heathcote', '(894) 375-9', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1979-09-29 21:11:07', NULL);
INSERT INTO `users` VALUES (5, 'Alicia Schuster', '+1-615-886-', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1999-11-04 16:48:51', NULL);
INSERT INTO `users` VALUES (6, 'Madonna Barrows', '(332) 301-0', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1997-04-17 23:45:01', NULL);
INSERT INTO `users` VALUES (7, 'Rubie Hudson', '547-895-530', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '2001-10-29 12:54:43', NULL);
INSERT INTO `users` VALUES (8, 'Prof. Kurtis Daniel', '+1772603111', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1980-03-08 10:52:56', NULL);
INSERT INTO `users` VALUES (9, 'Hazel Pacocha', '1-261-669-2', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1993-08-22 03:22:56', NULL);
INSERT INTO `users` VALUES (10, 'Jaleel Shanahan DDS', '(908) 257-7', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1993-02-27 08:03:35', NULL);
INSERT INTO `users` VALUES (11, 'Prof. Jay Koss', '1-452-463-7', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1988-12-12 14:49:47', NULL);
INSERT INTO `users` VALUES (12, 'Adonis Monahan', '(306) 737-5', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '2005-10-27 03:44:20', NULL);
INSERT INTO `users` VALUES (13, 'Jane King', '(931) 767-2', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1980-09-03 08:11:20', NULL);
INSERT INTO `users` VALUES (14, 'Yvette Hills', '727.320.424', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1982-12-02 17:44:06', NULL);
INSERT INTO `users` VALUES (15, 'Dr. Kylie Schmidt DVM', '1-526-627-2', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1970-08-22 06:08:08', NULL);
INSERT INTO `users` VALUES (16, 'Roxanne Bogan', '+1 (624) 50', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1973-08-12 21:23:18', NULL);
INSERT INTO `users` VALUES (17, 'Miss Jazlyn Durgan', '(835) 264-9', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1998-11-26 14:41:20', NULL);
INSERT INTO `users` VALUES (18, 'Doris Doyle', '(992) 931-8', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '2003-01-02 22:34:58', NULL);
INSERT INTO `users` VALUES (19, 'Barry Marks', '653.866.522', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '2000-09-26 23:11:33', NULL);
INSERT INTO `users` VALUES (20, 'Johan Roob', '(297) 344-9', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '2015-06-02 05:19:39', NULL);
INSERT INTO `users` VALUES (21, 'Florida Ruecker', '1-587-597-2', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '2004-11-28 02:27:08', NULL);
INSERT INTO `users` VALUES (22, 'Prof. Adela Quigley I', '+1 (571) 40', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1987-08-27 14:37:44', NULL);
INSERT INTO `users` VALUES (23, 'Denis Reinger', '565-780-323', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '2017-03-28 18:08:14', NULL);
INSERT INTO `users` VALUES (24, 'Jackie Simonis', '(824) 470-5', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1992-12-18 00:20:15', NULL);
INSERT INTO `users` VALUES (25, 'Amya Tremblay PhD', '618-998-616', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '2005-11-25 16:55:46', NULL);
INSERT INTO `users` VALUES (26, 'Dr. Orval Crist I', '1-958-625-9', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '2003-04-09 15:24:26', NULL);
INSERT INTO `users` VALUES (27, 'Kasandra Dibbert', '869-604-154', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1976-10-03 20:51:20', NULL);
INSERT INTO `users` VALUES (28, 'Cathrine Greenfelder V', '247-993-885', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '2018-12-03 20:22:37', NULL);
INSERT INTO `users` VALUES (29, 'Baylee Rowe', '450.719.967', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1977-10-31 19:25:07', NULL);
INSERT INTO `users` VALUES (30, 'Prof. Kenyon Schuppe', '+1.996.981.', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1993-11-20 01:35:25', NULL);
INSERT INTO `users` VALUES (31, 'Mellie Parker', '+1-631-871-', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1970-01-27 19:59:43', NULL);
INSERT INTO `users` VALUES (32, 'Lonzo Hane', '539-580-485', 'http://localhost/uploads/images/avatars/', NULL, NULL, NULL, NULL, '1997-10-28 12:57:19', NULL);

SET FOREIGN_KEY_CHECKS = 1;
