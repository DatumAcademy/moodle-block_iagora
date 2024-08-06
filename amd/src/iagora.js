import * as WebChat from "block_iagora/botframework-webchat";

/**
 * Initializes the chat with given parameters.
 * @param {Object} params - The initialization parameters.
 * @param {string} params.copilotUrl - The copilot.
 * @param {string} params.chatId - The chat container ID.
 */
export const init = ({copilotUrl, chatId}) => {
  // eslint-disable-next-line no-console
  console.log('Copilot URL:', copilotUrl);
  // eslint-disable-next-line no-console
  console.log('Chat ID:', chatId);
  initIagoraChat(copilotUrl, chatId);
};


/**
 * @param {string} copilotUrl
 * @param {string} chatId
 */
export async function initIagoraChat(copilotUrl, chatId) {
  try {
    const tokenEndpointURL = new URL(copilotUrl);
    const locale = document.documentElement.lang || 'en';
    const apiVersion = tokenEndpointURL.searchParams.get('api-version');
    const [directLineURL, token] = await Promise.all([
      fetch(new URL(`/powervirtualagents/regionalchannelsettings?api-version=${apiVersion}`, tokenEndpointURL))
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to retrieve regional channel settings.');
          }

          return response.json();
        })
        .then(({ channelUrlsById: { directline } }) => directline),
      fetch(tokenEndpointURL)
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to retrieve Direct Line token.');
          }

          return response.json();
        })
        .then(({ token }) => token)
    ]);

    // eslint-disable-next-line no-console
    console.log('WebChat', WebChat);


    const directLine = WebChat.createDirectLine({ domain: new URL('v3/directline', directLineURL), token });
    const subscription = directLine.connectionStatus$.subscribe({
      next(value) {
        if (value === 2) {
          directLine
            .postActivity({
                localTimezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                locale,
                name: "startConversation",
                type: "event"
            })
            .subscribe();
  
          subscription.unsubscribe();
        }
      }
    });
  
    const chatContainer = document.getElementById(chatId);
    WebChat.renderWebChat(
      {directLine, locale: document.documentElement.lang || "en"},
      chatContainer
    );
  } catch (error) {
      // eslint-disable-next-line no-console
      console.error("Error initializing chat:", error);
      chatContainer.innerHTML = "Failed to load chat. Please try again later.";
  }
}
