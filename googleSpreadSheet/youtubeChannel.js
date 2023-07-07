function getYoutubeChannelData() {
  var apiKey = 'AIzaSyBWSbfO0-G49Oy3AQgNshzkLn81gQRoKVw';
  var channelId = 'UC84IlgY5HIzxKBZOt8XM5UA';
  var errorLists = [];
  var msg = '정상적으로 실행되었습니다.';

  var spreadsheet = SpreadsheetApp.getActiveSpreadsheet();
  var sheet = spreadsheet.getSheetByName('Mplay 유튜브 시트');
  createSheetHeader(sheet);

  var { apiChannelUrl, apiSearchUrl } = createApiUrl(apiKey, channelId);

  try {
    var response = UrlFetchApp.fetch(apiChannelUrl);
    var json = JSON.parse(response.getContentText());

    if (typeof json.items[0] === 'undefined') return;

    var channelData = getChannelData(json.items[0]);
    createSheetBody(sheet, channelData);
  } catch (error) {
    console.log(error);
  }

  try {
    var response = UrlFetchApp.fetch(apiSearchUrl);
    var json = JSON.parse(response.getContentText());

    if (typeof json.items[0] === 'undefined') return;

    var videoIdList = getVideoId(json.items);
    var videoDataList = getVideoData(videoIdList, apiKey);
    createVideoSheet(sheet, videoDataList);
  } catch (error) {
    console.log(error);
  }
}
function createSheetHeader(sheet) {
  sheet.getRange('A1').setValue('채널명');
  sheet.getRange('B1').setValue('조회수');
  sheet.getRange('C1').setValue('영상수');
  sheet.getRange('D1').setValue('구독자수');
}
function createSheetBody(sheet, channelData) {
  var { channelTitle, viewCount, videoCount, subscriberCount } = channelData;

  sheet.getRange('A2').setValue(channelTitle);
  sheet.getRange('B2').setValue(viewCount);
  sheet.getRange('C2').setValue(videoCount);
  sheet.getRange('D2').setValue(subscriberCount);
}

function createVideoSheet(sheet, videoDataList) {
  if (videoDataList.length === 0) return false;
  sheet.getRange('A4:F4').merge().setHorizontalAlignment('center');
  sheet.getRange('A4').setValue('[ 동영상 리스트닷 !!!!! ]');

  var sheetA = sheet.getRange('A5').setValue('영상 제목');
  var sheetB = sheet.getRange('B5').setValue('영상 URL');
  var sheetC = sheet.getRange('C5').setValue('영상 설명');
  var sheetD = sheet.getRange('D5').setValue('조회수');
  var sheetE = sheet.getRange('E5').setValue('좋아요수');
  var sheetF = sheet.getRange('F5').setValue('댓글수');

  sheet.autoResizeColumn(sheetA.getColumn());
  sheet.autoResizeColumn(sheetB.getColumn());

  var startVideoSheetRange = 6;
  videoDataList.forEach((videoData, index) => {
    var sheetRangeNum = startVideoSheetRange + index;
    sheet.getRange('A' + sheetRangeNum).setValue(videoData.title);
    sheet.getRange('B' + sheetRangeNum).setValue(`https://www.youtube.com/watch?v=${videoData.id}`);
    sheet.getRange('C' + sheetRangeNum).setValue(videoData.description);
    sheet.getRange('D' + sheetRangeNum).setValue(videoData.viewCount);
    sheet.getRange('E' + sheetRangeNum).setValue(videoData.likeCount);
    sheet.getRange('F' + sheetRangeNum).setValue(videoData.commentCount);
  });
}

function createApiUrl(apiKey, channelId) {
  return {
    apiChannelUrl:
      'https://www.googleapis.com/youtube/v3/channels?id=' +
      channelId +
      '&key=' +
      apiKey +
      '&part=snippet,statistics',
    apiSearchUrl:
      'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=' +
      channelId +
      '&maxResults=50&key=' +
      apiKey,
  };
}

function getChannelData(items) {
  return {
    channelTitle: items.snippet.title,
    viewCount: items.statistics.viewCount,
    videoCount: items.statistics.videoCount,
    subscriberCount: items.statistics.subscriberCount,
  };
}

function getVideoId(items) {
  return items.map((item) => item.id.videoId);
}

function getVideoData(videoIdList, apiKey) {
  return videoIdList.map((videoId) => {
    var response = UrlFetchApp.fetch(
      'https://www.googleapis.com/youtube/v3/videos?id=' +
        videoId +
        '&key=' +
        apiKey +
        '&part=snippet,statistics'
    );
    var json = JSON.parse(response.getContentText());

    if (typeof json.items[0] === 'undefined') return null;

    var item = json.items[0];
    return {
      id: item.id,
      title: item.snippet.title,
      description: item.snippet.description,
      viewCount: item.statistics.viewCount,
      likeCount: item.statistics.likeCount,
      commentCount: item.statistics.commentCount,
    };
  });
}
