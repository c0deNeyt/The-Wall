        <form method="post" action="php/process.php">
            <input type="hidden" name="reviewAction" value="write">
            <label>Leave a Review
                <textarea name="latestReview" ></textarea>
            </label>
            <input class="post" type="submit">
        </form>
<?= displayReview(); ?>