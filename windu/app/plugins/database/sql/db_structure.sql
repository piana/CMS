# Create Statment for Windu CMS MySQL database;

DROP FUNCTION IF EXISTS strftime;
create function strftime (`format` VARCHAR(255), `d` DATE)   
   RETURNS varchar(64)
   LANGUAGE SQL
   DETERMINISTIC
   COMMENT 'synonym for date_format'
   return date_format(d,format);

DROP TABLE IF EXISTS `accesslog`;
CREATE TABLE `accesslog` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `pageId` int(11) ,
  `message` MEDIUMTEXT,
  `insertTime` timestamp,
  `ip` varchar(255) ,
  `url` varchar(255) ,
  `month` varchar(255) ,
  `day` varchar(255) ,
  `hour` varchar(255) ,
  `minuts` varchar(255) ,
  `visitCookie` int(11)
);

DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) ,
  `views` int(11) ,
  `clicks` int(11) ,
  `viewsLimit` int(11) ,
  `clicksLimit` int(11) ,
  `height` int(11) ,
  `link` varchar(255) ,
  `createTime` timestamp,
  `updateTime` timestamp,
  `createIP` varchar(255) ,
  `updateIp` varchar(255) ,
  `startDate` timestamp,
  `endDate` timestamp,
  `areaId` int(11) ,
  `status` int(11) ,
  `cookieCheck` int(11)
);

DROP TABLE IF EXISTS `bannerlog`;
CREATE TABLE `bannerlog` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `bannerId` int(11) ,
  `views` int(11) ,
  `clicks` int(11) ,
  `date` timestamp
);

DROP TABLE IF EXISTS `bannersareas`;
CREATE TABLE `bannersareas` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) ,
  `width` int(11) ,
  `height` int(11) ,
  `createTime` timestamp,
  `updateTime` timestamp,
  `createIP` varchar(255) ,
  `updateIp` varchar(255)
);

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `data` MEDIUMTEXT,
  `updateTime` datetime ,
  `bucket` varchar(255) ,
  `serialized` int(11)
);

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `userId` int(11) ,
  `createTime` datetime ,
  `content` MEDIUMTEXT,
  `bucket` varchar(255) ,
  `replayId` int(11) ,
  `updateTime` datetime ,
  `createIP` varchar(255) ,
  `updateIP` varchar(255) ,
  `status` int(11) ,
  `rating` int(11) ,
  `name` varchar(255) ,
  `email` varchar(255) ,
  `ekey` varchar(255)
);

DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `bucket` int(11) ,
  `nodelete` int(11) ,
  `name` varchar(255) ,
  `value` varchar(255) ,
  `description` MEDIUMTEXT,
  `shortDescription` varchar(255) ,
  `type` varchar(255),
  `options` MEDIUMTEXT
);

DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) ,
  `email` varchar(255) ,
  `createTime` timestamp,
  `updateTime` timestamp,
  `createIP` varchar(255) ,
  `updateIp` varchar(255) ,
  `bucket` int(11) ,
  `sendedEmails` int(11) ,
  `status` int(11) ,
  `ekey` varchar(255) ,
  `telephone` varchar(255) ,
  `mobile` varchar(255) ,
  `adress` varchar(255) ,
  `city` varchar(255) ,
  `code` varchar(255) ,
  `country` varchar(255) ,
  `taxid` varchar(255) ,
  `other` varchar(255)
);

DROP TABLE IF EXISTS `contactgroups`;
CREATE TABLE `contactgroups` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) 
);

DROP TABLE IF EXISTS `cronlog`;
CREATE TABLE `cronlog` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `bucket` int(11) ,
  `message` MEDIUMTEXT,
  `createTime` timestamp,
  `executeTime` varchar(255)
);

DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `bucket` varchar(255) ,
  `path` varchar(255) ,
  `fileName` varchar(255) ,
  `name` varchar(255) ,
  `description` MEDIUMTEXT,
  `size` int(11) ,
  `createTime` datetime ,
  `updateTime` datetime ,
  `createIP` varchar(255) ,
  `updateIP` varchar(255) ,
  `ekey` varchar(255) ,
  `type` varchar(255) ,
  `realType` varchar(255)
);

DROP TABLE IF EXISTS `fileslog`;
CREATE TABLE `fileslog` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `userId` int(11) ,
  `createTime` timestamp,
  `updateTime` timestamp,
  `createIP` varchar(255) ,
  `updateIp` varchar(255) ,
  `fileId` int(11)
);

DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `bucket` varchar(255) ,
  `position` int(11) ,
  `path` varchar(255) ,
  `fileName` varchar(255) ,
  `name` varchar(255) ,
  `description` MEDIUMTEXT,
  `size` int(11) ,
  `createTime` datetime ,
  `updateTime` datetime ,
  `createIP` varchar(255) ,
  `updateIP` varchar(255) ,
  `ekey` varchar(255) ,
  `type` varchar(255) ,
  `width` int(11) ,
  `height` int(11) ,
  `url` varchar(255)
);

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `bucket` int(11) ,
  `data` MEDIUMTEXT,
  `createTime` datetime ,
  `createIp` varchar(255),
  `userId` int(11)
);

DROP TABLE IF EXISTS `firewall`;
CREATE TABLE `firewall` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `accessLog` MEDIUMTEXT,
  `createTime` datetime ,
  `createIp` varchar(255),
  `status` int(11)
);

DROP TABLE IF EXISTS `mail`;
CREATE TABLE `mail` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `to` varchar(255) ,
  `senderId` int(11) ,
  `recipientId` int(11) ,
  `messageId` varchar(255) ,
  `createTime` datetime ,
  `updateTime` datetime ,
  `createIp` varchar(255) ,
  `updateIp` varchar(255)
);

DROP TABLE IF EXISTS `mailings`;
CREATE TABLE `mailings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) ,
  `contentId` int(11) ,
  `createTime` timestamp,
  `updateTime` timestamp,
  `createIP` varchar(255) ,
  `updateIp` varchar(255) ,
  `contactGroup` int(11) ,
  `sendedEmails` int(11) ,
  `status` int(11) ,
  `lastSendEmailId` int(11) ,
  `subject` varchar(255) ,
  `from` varchar(255) ,
  `senderName` varchar(255) ,
  `replay` varchar(255) ,
  `return` varchar(255)
);

DROP TABLE IF EXISTS `mailingtemplates`;
CREATE TABLE `mailingtemplates` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) ,
  `content` text
);

DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `content` MEDIUMTEXT,
  `userId` int(11) ,
  `createTime` timestamp,
  `updateTime` timestamp,
  `createIP` varchar(255) ,
  `updateIp` varchar(255)
);

DROP TABLE IF EXISTS `notify`;
CREATE TABLE `notify` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `insertTime` datetime ,
  `updateTime` datetime ,
  `priority` int(11) ,
  `closed` int(11),
  `url` varchar(255)
);

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `parentId` int(11) ,
  `type` int(2) ,
  `status` int(2) ,
  `position` int(11) ,
  `name` MEDIUMTEXT,
  `content` MEDIUMTEXT,
  `createTime` timestamp,
  `updateTime` timestamp,
  `createIP` varchar(255) ,
  `updateIp` varchar(255) ,
  `urlKey` varchar(255) ,
  `tpl` varchar(255) ,
  `title` varchar(255) ,
  `description` varchar(255) ,
  `keywords` varchar(255) ,
  `tags` varchar(255) ,
  `views` int(11) ,
  `date` datetime ,
  `lock` int(11) ,
  `defaultTpl` varchar(255) ,
  `authorId` int(11) ,
  `rate` int(11) ,
  `ekey` varchar(255) ,
  `hasIcon` int(11) ,
  `hasImage` int(11) ,
  `langId` int(11) ,
  `menuCssClass` varchar(255) ,
  `searchable` int(11) ,
  `logged` int(11) ,
  `priority` int(11) ,
  `rssSource` varchar(255)
);

DROP TABLE IF EXISTS `pagesbackups`;
CREATE TABLE `pagesbackups` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `pageId` int(11) ,
  `pageContent` MEDIUMTEXT,
  `createTime` timestamp,
  `createIP` varchar(255) ,
  `createUser` int(11)
);

DROP TABLE IF EXISTS `rates`;
CREATE TABLE `rates` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `rate` int(11) ,
  `elementId` int(11) ,
  `userId` varchar(255) ,
  `bucket` varchar(255) ,
  `createIp` varchar(255) ,
  `createTime` timestamp
);

DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `dataKey` varchar(255) ,
  `data` MEDIUMTEXT,
  `expire` datetime ,
  `usesNum` int(11) ,
  `insertIp` varchar(255)
);

DROP TABLE IF EXISTS `systemstatus`;
CREATE TABLE `systemstatus` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `date` date ,
  `images` int(11) ,
  `files` int(11) ,
  `sendedEmails` int(11) ,
  `contacts` int(11) ,
  `comments` int(11) ,
  `versions` int(11) ,
  `logErrors` int(11) ,
  `log404` int(11) ,
  `users` int(11) ,
  `revision` int(11) ,
  `size` int(11) ,
  `googlePageSpeed` int(11) ,
  `alexaCountryRank` int(11) ,
  `alexaGlobalRank` int(11) ,
  `pages` int(11) ,
  `rates` int(11) ,
  `googlePr` int(11) ,
  `alexaSpeed` int(11) ,
  `alexaLink` int(11) ,
  `pageViewsUniqueIP` int(11) ,
  `pageViewsUniqueCookie` int(11) ,
  `pageViewsUniqueCookiesIP` int(11) ,
  `requests` int(11),
  `forumTopics` int(11) ,
  `forumPosts` int(11)
);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `active` int(11) ,
  `email` varchar(255) ,
  `username` varchar(255) ,
  `password` varchar(255) ,
  `name` varchar(255) ,
  `surname` varchar(255) ,
  `type` int(11) ,
  `avatarId` int(11) ,
  `createTime` timestamp,
  `updateTime` timestamp,
  `createIP` varchar(255) ,
  `updateIp` varchar(255) ,
  `superAdministrator` int(11),
  `ekey` varchar(255)
);

DROP TABLE IF EXISTS `usertypes`;
CREATE TABLE `usertypes` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `extends` int(11) NOT NULL,
  `name` varchar(255) ,
  `bucket` int(11) ,
  `regexp` text NOT NULL,
  `panels` text
);

DROP TABLE IF EXISTS `polls`;
CREATE TABLE `polls` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) ,
  `description` MEDIUMTEXT,
  `status` int(11),
  `startTime` timestamp,
  `endTime` timestamp
  );

DROP TABLE IF EXISTS `pollanswers`;
CREATE TABLE `pollanswers` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `questionId` int(11),
  `createTime` timestamp,
  `createIP` varchar(255)
  );

DROP TABLE IF EXISTS `pollquestions`;
CREATE TABLE `pollquestions` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `pollId` int(11),
  `name` varchar(255) ,
  `ekey` varchar(255) ,
  `description` text
  );

DROP TABLE IF EXISTS `redirect`;
CREATE TABLE `redirect` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `type` int(11),
  `source` varchar(255) ,
  `target` int(11)
  );

DROP TABLE IF EXISTS `calendar`;
CREATE TABLE `calendar` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(45)  ,
  `status` int(11)
  );

DROP TABLE IF EXISTS `calendarevents`;
CREATE TABLE `calendarevents` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `calendarId` int(11),
  `name` varchar(45)  ,
  `description` MEDIUMTEXT,
  `date` timestamp,
  `status` int(11)
  );

DROP TABLE IF EXISTS `forums`;
CREATE TABLE `forums` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `status` INTEGER, 
  `position` INTEGER,
  `postsCount` INTEGER, 
  `topicsCount` INTEGER, 
  `groupsCount` INTEGER, 
  `name` varchar(255) ,
  `description` MEDIUMTEXT, 
  `createTime` timestamp,
  `updateTime` timestamp,
  `createIP` varchar(255),
  `updateIp` varchar(255),
  `ekey` varchar(255)
);

DROP TABLE IF EXISTS `forumgroups`;
CREATE TABLE `forumgroups` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `forumId` INTEGER, 
  `position` INTEGER,
  `status` INTEGER, 
  `postsCount` INTEGER, 
  `topicsCount` INTEGER, 
  `name` varchar(255) ,
  `description` MEDIUMTEXT, 
  `createTime` timestamp,
  `updateTime` timestamp,
  `createIP` varchar(255),
  `updateIp` varchar(255),
  `ekey` varchar(255)
);

DROP TABLE IF EXISTS `forumtopics`;
CREATE TABLE `forumtopics` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `groupId` INTEGER, 
  `status` INTEGER, 
  `postsCount` INTEGER, 
  `views` INTEGER, 
  `name` varchar(255) ,
  `createTime` timestamp,
  `updateTime` timestamp,
  `createIP` varchar(255),
  `updateIp` varchar(255),
  `ekey` varchar(255)
);

DROP TABLE IF EXISTS `forumposts`;
CREATE TABLE `forumposts` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `authorId` INTEGER, 
  `topicId` INTEGER, 
  `status` INTEGER, 
  `content` MEDIUMTEXT,
  `createTime` timestamp,
  `updateTime` timestamp,
  `createIP` varchar(255),
  `updateIp` varchar(255),
  `ekey` varchar(255)
); 

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `senderId` INTEGER, 
  `recipientId` INTEGER,
  `responseMessageId` INTEGER,
  `status` INTEGER, 
  `content` MEDIUMTEXT,
  `createTime` timestamp,
  `updateTime` timestamp,
  `createIP` varchar(255),
  `updateIp` varchar(255),
  `ekey` varchar(255)
);

DROP TABLE IF EXISTS `forumreadedlog`;
CREATE TABLE `forumreadedlog` (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `userId` INTEGER, 
  `topicId` INTEGER,
  `groupId` INTEGER
);