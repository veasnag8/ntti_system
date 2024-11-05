/*
 Navicat Premium Data Transfer

 Source Server         : computer
 Source Server Type    : MySQL
 Source Server Version : 80200 (8.2.0)
 Source Host           : localhost:3306
 Source Schema         : ks_01

 Target Server Type    : MySQL
 Target Server Version : 80200 (8.2.0)
 File Encoding         : 65001

 Date: 25/03/2024 18:33:42
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for slide_show
-- ----------------------------
DROP TABLE IF EXISTS `slide_show`;
CREATE TABLE `slide_show`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `picture_ori` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `picture_32bit` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `inactived` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
