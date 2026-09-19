-- ローカル Docker 用ログインユーザー (login: local / password: local)
-- AuthComponent::password() = sha1(Security.salt . password)。salt は docker/config/core.php と揃えること。
INSERT INTO `users` (`login`, `password`, `created`, `modified`)
VALUES ('local', SHA1(CONCAT('duelhLocalDockerSaltOnlyForDevelopment01', 'local')), NOW(), NOW());
