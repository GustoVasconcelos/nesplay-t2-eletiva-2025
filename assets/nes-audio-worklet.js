class NESAudioProcessor extends AudioWorkletProcessor {
    static get parameterDescriptors() {
        return [];
    }

    constructor() {
        super();
        // ring buffer de 4096 amostras estéreo
        this.SAMPLE_COUNT = 4096;
        this.SAMPLE_MASK = this.SAMPLE_COUNT - 1;
        this.bufferL = new Float32Array(this.SAMPLE_COUNT);
        this.bufferR = new Float32Array(this.SAMPLE_COUNT);
        this.writeCursor = 0;
        this.readCursor = 0;

        // recebe amostras via mensagem da main thread
        this.port.onmessage = (e) => {
            if (e.data.type === 'samples') {
                const { left, right } = e.data;
                // enfileira
                this.bufferL[this.writeCursor] = left;
                this.bufferR[this.writeCursor] = right;
                this.writeCursor = (this.writeCursor + 1) & this.SAMPLE_MASK;
            }
            // tratamento de reset de buffer
            if (e.data.type === 'reset') {
                this.readCursor = this.writeCursor;
            }
        };
    }

    process(inputs, outputs) {
        const outL = outputs[0][0];
        const outR = outputs[0][1];

        for (let i = 0; i < outL.length; i++) {
            const available = (this.writeCursor - this.readCursor) & this.SAMPLE_MASK;
            if (available === 0) {
                // sem dados suficientes, envia silêncio
                outL[i] = 0;
                outR[i] = 0;
            } else {
                outL[i] = this.bufferL[this.readCursor];
                outR[i] = this.bufferR[this.readCursor];
                this.readCursor = (this.readCursor + 1) & this.SAMPLE_MASK;
            }
        }

        return true;
    }
}

registerProcessor('nes-audio-processor', NESAudioProcessor);