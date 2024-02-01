using Microsoft.EntityFrameworkCore;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel;
using System.ComponentModel.DataAnnotations.Schema;

namespace RevenueManagement.Models.Entities
{
    [Table("companies")]
    public class Company
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "bigint")]
        public long Id { get; set; }

        [Column("name"), MaxLength(255)]
        public string? Name { get; set; } = string.Empty;

        [Column("address"), MaxLength(255)]
        public string? Address { get; set; } = string.Empty;

        [Column("phone"), MaxLength(15)]
        public string? Phone { get; set; } = string.Empty;

        [Column("email"), MaxLength(255)]
        public string? Email { get; set; } = string.Empty;

        [Column("image"), MaxLength(255)]
        public string? Image { get; set; } = string.Empty;

        [Column("user_subscribe"), MaxLength(255)]
        public string? UserSubscribe { get; set; } = string.Empty;

        [Column("date_incorporation")]
        public DateOnly? DateInCorporation { get; set; }

        [Column("status"), DefaultValue(1), Comment("1: active, 2: inactive")]
        public int Status { get; set; }

        [Column("created_at")]
        public DateTime? CreatedAt { get; set; }

        [Column("updated_at")]
        public DateTime? UpdatedAt { get; set; }

        [Column("deleted_at")]
        public DateTime? DeletedAt { get; set; }
    }
}
