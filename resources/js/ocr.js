import Tesseract from 'tesseract.js';

const OCR = {
    recognizeImage: async (imageUrl) => {
        try {
            const result = await Tesseract.recognize(
                imageUrl,
                'eng',
                {
                    logger: (m) => console.log(m),
                }
            );
            return result.data.text;
        } catch (error) {
            console.error(error);
            return null;
        }
    }
};

export default OCR;
