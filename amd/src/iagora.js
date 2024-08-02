import WebChat from 'botframework-webchat';
/**
 * Initializes the chat with given parameters.
 * @param {Object} params - The initialization parameters.
 * @param {string} params.copiloturl - The copilot.
 * @param {string} params.categoryid - The category ID.
 * @param {string} params.chatId - The chat container ID.
 */

export const init = ({copiloturl}) => {
    // eslint-disable-next-line no-console
    console.log('Copilot URL:', copiloturl);
    //initIagoraChat(chatId);
};
/**
 *
 * @param {string} chatId
 */
export function initIagoraChat(chatId) {
 const chatContainer = document.getElementById(chatId);

        // Static token and directLine URL (example values)
        const directLineURL = 'https://directline.botframework.com';
        const token = chatId ;
        try {
            const directLine = WebChat.createDirectLine({domain: new URL("v3/directline", directLineURL), token});

            const subscription = directLine.connectionStatus$.subscribe({
                next(value) {
                    if (value === 2) {
                        directLine
                            .postActivity({
                                localTimezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                                locale: document.documentElement.lang || "en",
                                name: "startConversation",
                                type: "event"
                            })
                            .subscribe();

                        subscription.unsubscribe();
                    }
                }
            });

            WebChat.renderWebChat({directLine, locale: document.documentElement.lang || "en"}, chatContainer);
        } catch (error) {
                    // eslint-disable-next-line no-console
            console.error("Error initializing chat:", error);
            chatContainer.innerHTML = "Failed to load chat. Please try again later.";
        }
    }

    export default {
        init,
        initIagoraChat
    };