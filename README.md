# Telegram Bot Welcome Message
Open Source Bot Telegram By @RasiTechChannel1

This PHP code provides a Telegram bot that sends a welcome message to new members when they join a group. The bot also responds with usage information when users send the "/start" command.

## Prerequisites
- PHP server
- Telegram bot token (obtained from BotFather)

## Setup
1. Replace <b>`TOKEN_BOT_TELEGRAM`</b> in the code with your actual Telegram bot token.
2. Deploy the code to a server accessible by Telegram.
3. Set up a webhook to receive messages using tools like ngrok (for local development) or a public server.
4. Start the bot and invite it to your Telegram group.

## Usage
- When a new member joins the group, the bot will send a welcome message along with their profile photo.
- Send the "/start" command to the bot to receive information about its usage.

## Code Explanation
- The code uses the Telegram Bot API to send messages and retrieve user information.
- The <b>`sendMessage`</b> function sends a text message to a specified chat ID.
- The <b>`sendPhotoWithCaption`</b> function sends a photo with a caption to a specified chat ID.
- The script checks for two scenarios: receiving a message or new members joining the group.
- If the received message is "/start", the bot sends usage information.
- If new members join the group, the bot retrieves their profile photos and sends a welcome message with the photo.

Feel free to customize the welcome message, usage information, or any other part of the code to fit your requirements.

<b>Note</b>: Make sure to keep your bot token confidential and secure.
