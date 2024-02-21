using Microsoft.EntityFrameworkCore;
using System.ComponentModel;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace RevenueManagement.Models.Entities
{
    [Table("users")]
    public class User
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "bigint")]
        public long Id { get; set; }

        [Column("name"), MaxLength(255)]
        public string? Name { get; set; } = string.Empty;

        [Column("username"), MaxLength(255)]
        public string? Username { get; set; } = string.Empty;

        [Column("password"), MaxLength(255)]
        public string? Password { get; set; } = string.Empty;

        [Column("phone"), MaxLength(15)]
        public string? Phone { get; set; } = string.Empty;

        [Column("email"), MaxLength(255)]
        public string? Email { get; set; } = string.Empty;

        [Column("image"), MaxLength(255)]
        public string? Image { get; set; } = string.Empty;

        [Column("sex"), DefaultValue("1"), Comment("1: male, 2: female")]
        public int? Sex { get; set; } = 1;

        [Column("date_of_birth")]
        public DateOnly? DateOfBirth { get; set; }

        [Column("role_id")]
        public int? RoleId { get; set; }

        [Column("created_at")]
        public DateTime? CreatedAt { get; set; }

        [Column("updated_at")]
        public DateTime? UpdatedAt { get; set; }

        [Column("deleted_at")]
        public DateTime? DeletedAt { get; set; }
    }
}
