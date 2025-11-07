document.addEventListener('DOMContentLoaded', () => {
    const contactForm = document.getElementById('contactForm');
    if (!contactForm) return;

    if (typeof emailjs !== 'undefined') {
        emailjs.init('YOUR_EMAILJS_PUBLIC_KEY');
    }

    contactForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        const submitBtn = contactForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';

        try {
            const payload = {
                from_name: contactForm.name.value,
                from_email: contactForm.email.value,
                subject: contactForm.subject.value,
                message: contactForm.message.value,
            };

            await emailjs.send('YOUR_SERVICE_ID', 'YOUR_TEMPLATE_ID', payload);
            alert('Message sent successfully!');
            contactForm.reset();
        } catch (error) {
            console.error('EmailJS error:', error);
            alert('Failed to send message. Please try again.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
});