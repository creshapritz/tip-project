<?php

function ticketCreatedTemplate($ticketNumber, $email, $appointmentTime)
{
    return "
        <html>
        <body>
            <h2>Ticket Created Successfully</h2>

            <p>Hello,</p>

            <p>Your ticket has been successfully created.</p>

            <p>
                <strong>Ticket Number:</strong>
                {$ticketNumber}
            </p>

            <p>
                <strong>Email:</strong>
                {$email}
            </p>

            <p>
                <strong>Appointment Time:</strong>
                {$appointmentTime}
            </p>

            <p>
                Please keep your ticket number for reference.
            </p>

            <p>Thank you!</p>
        </body>
        </html>
    ";
}

function appointmentReminderTemplate($ticketNumber, $email, $appointmentTime)
{
    return "
        <html>
        <body>
            <h2>Ticket Created Successfully</h2>

            <p>Hello,</p>

            <p>Your ticket has been successfully created.</p>

            <p>
                <strong>Ticket Number:</strong>
                {$ticketNumber}
            </p>

            <p>
                <strong>Email:</strong>
                {$email}
            </p>

            <p>
                <strong>Appointment Time:</strong>
                {$appointmentTime}
            </p>

            <p>
                Please keep your ticket number for reference.
            </p>

            <p>Thank you!</p>
        </body>
        </html>
    ";
}