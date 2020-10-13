<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><span :class="messageClass">{{ message }}</span></div>

                    <div class="card-body">
                        <qrcode-stream @decode="onDecode"></qrcode-stream>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'vue-qrcode-reader'
    import api from '../services/qrScan.js'

    export default {
        components: {
            QrcodeStream
        },
        data() {
            return {
                message: 'Qr Scanner',
                messageClass: 'text-primary'
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            async onDecode(decodedString) {
                if (decodedString != '') {
                    this.message = "Leyendo..."
                    this.messageClass = 'text-primary'
                    try {
                        var response = await api.checkAuthorization(decodedString)
                        console.log(decodedString)
                        if (response.status == "1") {
                            this.message = 'Autorizado: ' + response.name
                            this.messageClass = 'text-success'
                        } else {
                            this.message = response.name + ' - ' + response.message
                            this.messageClass = 'text-danger'
                        }
                    }
                    catch (e) {
                        console.log(e)
                    }
                }
            }
        }
    }
</script>
