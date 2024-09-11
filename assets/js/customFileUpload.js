function generateUUID() {
    let uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        let r = Math.random() * 16 | 0, 
            v = c === 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
    return uuid;
}

class customFileUpload {
    constructor(base64, uuid, id, fileName, options = {}) {
        this.base64 = base64;
        this.uuid = uuid;
        this.id = id;
        this.fileName = fileName;
        this.options = $.extend({
            callback: (data) => { },
            uploadURL: "",
            uploadMethod: "post",
            csrfToken: "",
        }, options);
        this.addLoader();
        this.upload();
    }
    addLoader() {
        $('#' + this.id).parent().append('<div class="upload-progress" data-id="' + this.id + '"><div class="circle-loader"><svg width="150" height="150" viewBox="0 0 160 160"><circle class="circle circle-bg" cx="65" cy="65" r="60"></circle><circle class="circle circle-progress" cx="65" cy="65" r="60" id="circle-progress"></circle></svg><div class="loader-text" id="loader-text">0%</div></div></div>');
    }
    removeLoader() {
        $('#' + this.id).parent().find('.upload-progress').remove();
    }
    getBlob() {
        let base64String = this.base64; 
        let tmp = base64String.split(';base64,');
        if (base64String.length > 0) {
            base64String = tmp[1];
        }
        // Decode the Base64 string
        let binaryString = atob(base64String);
        let len = binaryString.length;
        let bytes = new Uint8Array(len);
        for (let i = 0; i < len; i++) {
            bytes[i] = binaryString.charCodeAt(i);
        }
        // Create a Blob from the binary data
        let blob = new Blob([bytes], { type: 'application/octet-stream' });
        return blob;
    }
    upload() {

        const updateUploadPercentage =  async(percentage) => {
            //let percentage = (completedRequests*100)/this.totalChunks;
            const circleProgress = document.querySelector('.upload-progress[data-id="' + this.id + '"] .circle-progress');
            const loaderText = document.querySelector('.upload-progress[data-id="' + this.id + '"] .loader-text');
            const radius = 70;
            const circumference = 2 * Math.PI * radius;
            if (percentage <= 100) {
                const offset = circumference - (percentage / 100) * circumference;
                circleProgress.style.strokeDashoffset = offset;
                loaderText.textContent = parseFloat(percentage).toFixed(2) + '%';
            }
        }
        const uploadImage =  async () => {
            var blob =  this.getBlob();
            var formData = new FormData();
            formData.append('image', blob, this.fileName);
           let response= await new Promise(async(resolve,reject)=>{
                $.ajax({
                    url: this.options.uploadURL,
                    type:this.options.uploadMethod,
                    headers: { 'X-CSRF-Token': $('meta[name=_token]').attr('content') },
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                percentComplete = parseFloat(percentComplete).toFixed(2);
                                updateUploadPercentage(percentComplete);
                                //$('#divProcessText').html(percentComplete+'% Completed.<br> Please wait for until upload process complete.');
    
    
                                //Do something with upload progress here
                            }
                        }, false);
                        return xhr;
                    },
                    beforeSend: function () {
                        updateUploadPercentage(0);
                    },
                    success: function (response) {
                        resolve(response);
                    },
                    error: function (error) {resolve({},"","","");}
                });
            });
            this.removeLoader();
            this.options.callback(response, this.id, this.uuid, this.fileName);
        }
        uploadImage();
    }
}