# 🪞 Online-Mirror · 网恋照妖镜

[![Stars](https://img.shields.io/github/stars/fruge365/Online-Mirror?style=flat-square&color=B29A6B)](https://github.com/fruge365/Online-Mirror/stargazers)
[![PHP](https://img.shields.io/badge/PHP-5.6%2B-777BB4?style=flat-square&logo=php)](https://www.php.net/)
[![Files](https://img.shields.io/badge/单文件-无数据库-2E8B8B?style=flat-square)](#项目结构)

一个 PHP 单文件小工具：生成一条链接发给对方，对方打开后浏览器会调用摄像头拍下一张照片并保存，你再用 ID 查看结果。全部逻辑由几个 PHP 文件组成，**不需要数据库、不需要框架**。

> ⚠️ **重要声明**
> 本项目仅用于学习 Web 摄像头 API 与 PHP 文件上传的技术原理。
> **未经他人明确同意拍摄、收集他人影像属于侵犯隐私，可能违法**。请勿用于任何真实场景，作者不对使用后果负责。

## 原理

```text
1. sc.php   → 生成带 ID 的链接，发给对方
2. index.php → 对方打开链接，getUserMedia 调摄像头，canvas 截图
3. qbl.php   → 接收 base64 图片，按 ID 落盘到 img/
4. ck.html   → 用 ID 打开，查看已保存的照片
```

## 项目结构

```text
Online-Mirror/
├─ index.php   拍摄页：调用摄像头、canvas 截图、提交 base64
├─ sc.php      生成页：输入 ID 与跳转地址，生成分享链接
├─ qbl.php     接收页：校验参数、解码 base64、写入 img/ 目录
├─ ck.php      查看页：按 ID 展示已保存的照片
└─ README.md
```

## 部署

需要 PHP 5.6+ 与支持 HTTPS 的 Web 服务器。

```bash
# 1. 放到站点目录
cd /var/www/html
git clone https://github.com/fruge365/Online-Mirror.git mirror

# 2. 确保 img 目录可写（qbl.php 会自动创建，也可手动建）
mkdir -p mirror/img && chmod 777 mirror/img

# 3. 浏览器访问生成页
# http://your-domain/mirror/sc.php
```

浏览器调用摄像头要求 **HTTPS 或 localhost**。用 HTTP 域名访问时，`getUserMedia` 会被浏览器直接拒绝。

## 使用流程

1. 打开 `sc.php`，填写你自己的 ID 和拍摄后要跳转的地址（例如 `http://baidu.com`）
2. 点击生成链接，复制后发给对方
3. 对方打开链接、允许摄像头权限，约 1 秒后截图并提交
4. 你用同一个 ID 打开 `ck.php` 查看照片

**ID 是唯一凭证**，没有账号体系。ID 泄露等于照片泄露。

## 常见问题

**拍出来是黑屏？**
浏览器不支持或未授权 `getUserMedia`。换 Chrome / Edge 新版本，确认已点"允许"，并确保通过 HTTPS 访问。

**照片只有一部分 / 不完整？**
`index.php` 截图后立即提交并跳转。对方在跳转完成前关闭页面，上传会被中断。

**照片存在哪？**
`qbl.php` 写入站点目录下的 `img/`，文件名格式为 `{ID}_{月日时分秒}.{png|bmp}`。代码只接受 `bmp` 与 `png` 两种类型。

**数据会保留多久？**
**代码里没有任何清理逻辑**，不会自动删除。原始 README 说"不定期删除 7 天前的数据"是指部署者手动清理，仓库本身不提供该功能。请自行用 cron 处理，或干脆不要部署到公网。

**支持 iPhone 吗？**
`index.php` 直接请求 `{ video: true }` 前置摄像头，未针对 iOS Safari 做兼容处理，实际表现需自行测试。

## 安全与合规提示

- 本项目**没有任何访问控制**：知道 ID 就能看图，知道 `img/` 路径就能遍历文件
- 图片以明文存在 Web 根目录下，**可被直接 URL 访问**
- 无频率限制、无内容校验，切勿部署到生产环境或开放公网
- 请勿将其用于未经同意的拍摄。相关行为在中国大陆受《个人信息保护法》《治安管理处罚法》约束

## 许可

仅供学习交流。使用前请确认你的用途合法合规。
