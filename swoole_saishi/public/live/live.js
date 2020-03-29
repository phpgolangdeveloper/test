var wsUrl = 'ws://39.108.6.204:8811';
var websocket = new WebSocket(wsUrl);
console.log(123);
// 实例对象的 onopen属性
websocket.onopen = function (evt) {
    console.log('coneccted-swoole-success');
}
// 实例化 onmessage
websocket.onmessage = function (evt) {
    console.log('ws-server-return-data:' + evt.data);
}
// 关闭
websocket.onclose = function (evt) {
    console.log('closw');
}

websocket.onerror = function (evt, e) {
    console.log('error:' + e.data);
}