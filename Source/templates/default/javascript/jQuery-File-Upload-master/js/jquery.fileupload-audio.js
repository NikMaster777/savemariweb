(function(factory){'use strict';if(typeof define==='function'&&define.amd){define(['jquery','load-image','./jquery.fileupload-process'],factory)}else if(typeof exports==='object'){factory(require('jquery'),require('blueimp-load-image/js/load-image'),require('./jquery.fileupload-process'))}else{factory(window.jQuery,window.loadImage)}}(function($,loadImage){'use strict';$.blueimp.fileupload.prototype.options.processQueue.unshift({action:'loadAudio',prefix:!0,fileTypes:'@',maxFileSize:'@',disabled:'@disableAudioPreview'},{action:'setAudio',name:'@audioPreviewName',disabled:'@disableAudioPreview'});$.widget('blueimp.fileupload',$.blueimp.fileupload,{options:{loadAudioFileTypes:/^audio\/.*$/},_audioElement:document.createElement('audio'),processActions:{loadAudio:function(data,options){if(options.disabled){return data}
var file=data.files[data.index],url,audio;if(this._audioElement.canPlayType&&this._audioElement.canPlayType(file.type)&&($.type(options.maxFileSize)!=='number'||file.size<=options.maxFileSize)&&(!options.fileTypes||options.fileTypes.test(file.type))){url=loadImage.createObjectURL(file);if(url){audio=this._audioElement.cloneNode(!1);audio.src=url;audio.controls=!0;data.audio=audio;return data}}
return data},setAudio:function(data,options){if(data.audio&&!options.disabled){data.files[data.index][options.name||'preview']=data.audio}
return data}}})}))