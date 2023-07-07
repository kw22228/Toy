function getYoutubeData() {
  var apiKey = 'AIzaSyBWSbfO0-G49Oy3AQgNshzkLn81gQRoKVw'; // 제 아이디 key니깐 바꿔서 쓰세요..ㅎ
  var errorLists = [];
  var msg = '정상적으로 실행되었습니다.';

  var spreadsheet = SpreadsheetApp.getActiveSpreadsheet();
  var sheet = spreadsheet.getSheetByName('시트1');
  var sheetRange = sheet.getRange('A1:A').getValues();

  sheetRange.forEach((values, index) => {
    var value = values[0] ?? null;
    if (!value) return;

    var apiUrl = createApiUrl(apiKey, extractVideoId(value));

    try {
      var response = UrlFetchApp.fetch(apiUrl);
      var json = JSON.parse(response.getContentText());

      if (typeof json.items[0] === 'undefined') return;

      var { title, channelTitle } = getVideoData(json.items[0]);

      sheet.getRange(`B${index + 1}`).setValue(title);
      sheet.getRange(`C${index + 1}`).setValue(channelTitle);
    } catch (e) {
      errorLists.push({ url: value, error: e });
    }
  });

  if (errorLists.lenth > 0) msg = `오류발생!! ${errorLists}`;

  console.log(msg);
}

function extractVideoId(url) {
  var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
  var match = url.match(regExp);
  return match && match[7].length === 11 ? match[7] : false;
}

function createApiUrl(apiKey, videoId) {
  return (
    'https://www.googleapis.com/youtube/v3/videos?id=' +
    videoId +
    '&key=' +
    apiKey +
    '&part=snippet'
  );
}

function getVideoData(item) {
  // console.log(item); //주석풀면 로그 확인
  return {
    // 필요하면 데이터 추가해주세영 (log보면 나와이씀)
    title: item.snippet.title,
    channelTitle: item.snippet.channelTitle,
  };
}
