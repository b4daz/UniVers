# 🌟 UniVers Plugin 🌟

**UniVers** is a PocketMine plugin that ensures **Minecraft Bedrock** version compatibility across servers. With this plugin, players from compatible versions can join your server, while players using unsupported versions will be kicked with a customizable message.

---

## 🚀 Features

- **Version Compatibility:** Easily configurable supported versions in the `config.json`.
- **Customizable Messages:** Modify the join and kick messages to suit your needs.
- **Seamless Experience:** Ensures smooth version handling for players on supported versions.

---

## 📦 Installation

1. **Download** the plugin ZIP file from the [releases](https://github.com/b4daz/UniVers) page.
2. **Place** the ZIP file directly into the `plugins/` folder of your PocketMine server.
3. **Extract** the ZIP file in the `plugins/` folder. This will create a folder called `UniVers`.
4. **Restart** your PocketMine server to load the plugin.

---

## ⚙️ Configuration

Customize the accepted versions and kick messages by editing the `config.json` file.

```json
  {
    "minimumProtocol": 431,
    "maximumProtocol": 766,
    "kickMessageOld": "Your version is too old. Please update to join the server.",
    "kickMessageNew": "Your version is too new. Please downgrade to join the server."
}
