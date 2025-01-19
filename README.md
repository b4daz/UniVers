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
  "kickMessage": "Your version is not compatible with this server. Please use a compatible version. Your current version: {version}.",
  "versionMismatchMessages": {
    "older": "You are using an older version of Minecraft Bedrock. Please update to a version supported by the server.",
    "newer": "You are using a newer version of Minecraft Bedrock. Some features may not be fully supported."
  },
  "accepted_protocols": [
    448,
    465,
    471,
    475,
    486,
    503,
    527,
    534,
    544,
    560,
    567,
    575,
    582,
    589
  ]
}
