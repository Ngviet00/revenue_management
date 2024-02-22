using Microsoft.EntityFrameworkCore.Migrations;

#nullable disable

namespace RevenueManagement.Migrations
{
    /// <inheritdoc />
    public partial class add_relationship_notification_user : Migration
    {
        /// <inheritdoc />
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.CreateIndex(
                name: "IX_notifications_receive_user_id",
                table: "notifications",
                column: "receive_user_id");

            migrationBuilder.AddForeignKey(
                name: "FK_notifications_users_receive_user_id",
                table: "notifications",
                column: "receive_user_id",
                principalTable: "users",
                principalColumn: "id",
                onDelete: ReferentialAction.Cascade);
        }

        /// <inheritdoc />
        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropForeignKey(
                name: "FK_notifications_users_receive_user_id",
                table: "notifications");

            migrationBuilder.DropIndex(
                name: "IX_notifications_receive_user_id",
                table: "notifications");
        }
    }
}
